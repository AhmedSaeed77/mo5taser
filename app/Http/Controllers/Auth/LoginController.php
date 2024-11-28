<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Account\ResetPasswordOtpVerifiedRequest;
use App\Http\Requests\Account\ResetPasswordOtpVerifyRequest;
use App\Http\Requests\Account\ResetPasswordRequest;
use App\Http\Requests\Account\VerifyOtpRequest;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', '_verify', 'verify', 'verifyResend']);
    }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated($request , $user)
    {

        Auth::guard('web')->logoutOtherDevices($request->get('password'));

        if(auth()->user()->role_id == 4)
        {
            return redirect('/account');
        }
        else
        {
            return redirect('/');
        }
    }






    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function login(\Illuminate\Http\Request $request)
    {
        $this->validateLogin($request);
        $user = User::where(['email' => $request->{$this->username()}])->first();
        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {


            // Make sure the user is active
            if ($user->active == 1 && $this->attemptLogin($request)) {
                // Send the normal successful login response
                 return $this->sendLoginResponse($request);
            }
            else {
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['failed' => __('auth.failed')]);
            }
        }
        // else if (isset($user) && $user->active == 0) {
        //     return redirect()->route('verify_code');
        // }
        else
        {
            return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['failed' =>  __('auth.failed')]);
        }

    }

    public function credentials(Request $request)
    {
        return ['email' => $request->{$this->username()} , 'password' => $request->password , 'active' => '1'];
    }

    public function _verify() {
//        if (auth()->user()->otp !== null) {
            $this->sendOTP();
//        }
        return view('auth.verify_otp');
    }

    public function verify(VerifyOtpRequest $request) {
        if ($request->otp == auth()->user()->otp) {
            auth()->user()->update(['is_verified' => true]);
            return redirect('/')->with(['success' => __('lang.Account verified successfully')]);
        } else {
            return redirect()->route('verify_otp')->with(['failed' => __('lang.OTP does not match with what we have sent')]);
        }
    }

    public function verifyResend() {
        $this->sendOTP();
        return redirect()->route('verify_otp')->with(['success' => __('lang.OTP was resent')]);
    }

    private function sendOTP() {
        auth()->user()->update(['otp' => random_int(10000, 99999)]);
        $Numbers = auth()->user()->phone;
        $Originator="Mobile.SA";
        $Message= 'رمز تأكيد الحساب الخاص بك هو: ' . auth()->user()->otp;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.mobile.net.sa/api/v1/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "number":"'.$Numbers.'",
                "senderName":"'.$Originator.'",
                "sendAtOption":"Now",
                "messageBody":"'.$Message.'",
                "allow_duplicate":true
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer oN1jvbbROzzkM2jlESsjix6PpHraBT1mEn0VVN4b',
                'Accept: application/json',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        Log::warning('sms verify code sent: '. $response);

        curl_close($curl);
        return json_decode($response);


    }

    public function _reset()
    {
        return view('auth.reset-password');
    }

    public function _resetOtp(ResetPasswordRequest $request) {
        $phone = $request->phone;
        $user =  User::query()->where('phone', $phone)->first();
        $token = random_int(100, 999) . $user->id . random_int(100, 999);
        // $token = random_int(1000, 9999) . $user->id;
        $this->resetPasswordOtp($user, $token);
        return redirect()->route('reset_password_otp_token', $token);
    }

    public function resetOtp($token) {
        return view('auth.reset-password-otp', ['token' => $token]);
    }

    public function _resetOtpVerify(ResetPasswordOtpVerifyRequest $request, $token) {
        $isVerified = User::query()->where('code', $request->otp)->where('code_token', $request->token)->exists();
        if ($isVerified) {
            $user = User::query()->where('code', $request->otp)->where('code_token', $request->token)->first();
            return view('auth.reset-password-otp-verified', ['token' => $user->code_token]);
        } else {
            $user = User::query()->where('code_token', $request->token)->first();
            if ($user !== null) {
                return redirect()->route('reset_password_otp_token', $user->code_token)->with(['failed' => __('lang.OTP does not match with what we have sent')]);
            } else {
                return redirect()->route('reset_password');
            }
        }
    }

    public function resetOtpVerifyWithToken($token) {
        $user = User::query()->where('code_token', $token)->first();
        return view('auth.reset-password-otp-verified', ['token' => $user->code_token]);
    }

    public function resetOtpVerify(ResetPasswordOtpVerifiedRequest $request) {
        $user = User::query()->where('code_token', $request->token)->first();
        if ($user !== null) {
            $user->update([
                'password' => bcrypt($request->password),
                'code' => null,
                'code_token' => null,
            ]);
            return redirect()->route('login')->with(['success' => __('lang.Password changed successfully')]);
        } else {
            return redirect()->route('reset_password')->with(['failed' => __('lang.Something went wrong while changing password')]);
        }
    }

    private function resetPasswordOtp($user, $token) {

        $user->update(['code' => random_int(10000, 99999), 'code_token' => $token]);
        $Numbers = $user->phone;
        $Originator="Mobile.SA";
        $Message= 'رمز استعادة الحساب الخاص بك هو: ' . $user->code;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.mobile.net.sa/api/v1/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "number":"'.$Numbers.'",
                "senderName":"'.$Originator.'",
                "sendAtOption":"Now",
                "messageBody":"'.$Message.'",
                "allow_duplicate":true
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer oN1jvbbROzzkM2jlESsjix6PpHraBT1mEn0VVN4b',
                'Accept: application/json',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);


    }


}
