<?php

namespace App\Http\Controllers\Api\Users;


use App\Http\Requests\Account\ResetPasswordRequest;
use App\Http\Requests\Account\VerifiedResetTokenRequest;
use App\Http\Requests\Account\VerifyOtpRequest;
use App\Http\Requests\Account\VerifyResetTokenRequest;
use App\Http\Requests\User\ApiSendOtpRequest;
use JWTAuth;
use App\Models\User;
use App\Models\Course;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CourseResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\SubscribeResource;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserPhoneLoginRequest;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use App\Http\Requests\NotificationRequest\changeNotificationRequest;

class UserController extends Controller
{

    use FileManagerTrait;
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['data' => __('lang.invalid_credentials'),'status' => 400]);
            }

        } catch (JWTException $e) {
            return response()->json(['data' =>  __('lang.could_not_create_token'),'status' => 500]);
        }
        auth()->guard('web')->logoutOtherDevices($request->get('password'));
        $user = new UserResource(JWTAuth::user(), true);
        $user->update(['google_device_token' => $request->google_device_token]);
        return response()->json(['data' => $user ,'status' => 200]);
    }

    public function register(UserRequest $request)
    {
        $user =  User::create([
            'name' => $request->name,
            'type' => 'student',
            'phone' => $request->phone,
            'email' => $request->email,
            'educational_level' => $request->educational_level,
            'level' => $request->level,
            'role_id' => 4,
            'image' => $this->upload('image','users'),
            'code' => rand(10000,99999),
            'active' => 1,
            'password' => Hash::make($request->password),
            'google_device_token' => $request->google_device_token,
            'is_verified' => 0,
        ]);
        $token = JWTAuth::fromUser($user);
        $user = new UserResource($user);
        return response()->json(['data' => $user , 'status' => 201 ]);

    }

    public function getAuthenticatedUser()
    {

        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['data' => __('lang.user_not_found'),'status' => 404]);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['data' => __('lang.token expired'),'status' => $e->getStatusCode()]);

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['data' => __('lang.invalid token'),'status' => $e->getStatusCode()]);

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['data' => __('lang.token absent'),'status' => $e->getStatusCode()]);
        }

        return response()->json(['data' => new UserResource($user) , 'status' => 200 ]);
    }

    public function logOut(Request $request ) {
        $token = $request->header('Authorization' );

        try {
            $user = JWTAuth::user();
            $user->update(['google_device_token' => NULL]);
            JWTAuth::parseToken()->invalidate( $token );

            return response()->json(['data' => __('lang.loged_out'),'status' => 200]);
        } catch ( TokenExpiredException $exception ) {
            return response()->json(['data' => __('lang.token_expired'),'status' => 401]);
        } catch ( TokenInvalidException $exception ) {
            return response()->json(['data' => __('lang.invalid token'),'status' => 401]);
        } catch ( JWTException $exception ) {
            return response()->json(['data' => __('lang.token_missing'),'status' => 500]);
        }
    }

    public function UserVerify(Request $request ) {

        $user = User::where(['phone' => $request->phone,'code' => $request->code,])->first();
        try {
            if(isset($user) )
            {
                $user->update(['active' => 1]);
                $user = new UserResource($user);
                return response()->json(['data' => $user,'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.invalid_credentials'),'status' => 400]);
            }
        } catch (JWTException $e) {
            return response()->json(['data' => $e->getMessage()], $e->getStatusCode());
        }

        $user = new UserResource(JWTAuth::user());
        return response()->json(['data' => $user , 'token' => $token],200);
    }

    // user login with phone
    public function LoginWithPhone(UserPhoneLoginRequest $request)
    {
        $user = User::where('phone',$request->phone)->first();
        try {
            if(isset($user))
            {
                $user->update(['active' => 1,'code' => rand(1000, 9999),'google_device_token' => $request->google_device_token]);
                $token = JWTAuth::fromUser($user);
                $user = new UserResource($user);
                return response()->json(['data' => $user,'status' => 200]);
            }
            else
            {
                return response()->json(['data' => __('lang.invalid_credentials'),'status' => 400]);
            }
        } catch (JWTException $e) {
            return response()->json(['data' =>  __('lang.invalid_credentials'), 'status' => $e->getStatusCode()]);
        }

    }


    // user update
    public function UpdateProfile(UserRequest $request)
    {
        $user = JWTAuth::user();
        try {
                if(isset($user))
                {
                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => $request->password ? Hash::make($request->password) : $user->password,
                        'type' => 'student',
                        'educational_level' => $request->educational_level,
                        'level' => $request->level,
                        'image' => $request->image ? $this->updateFile('image','users',$user->image) : $user->image
                    ]);
                    $token = JWTAuth::fromUser($user);
                    $user = new UserResource($user);
                    return response()->json(['data' => $user,'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => __('site.error_user_data'),'status' => 422]);
                }
        } catch (JWTException $e) {
            return response()->json(['data' => $e->getMessage()], $e->getStatusCode());
        }

    }

    // user UpdatePassword
    public function UpdatePassword(UserPasswordRequest $request)
    {

        $user = JWTAuth::user();
        try {
                if(isset($user))
                {
                    if(Hash::check($request->current_password, $user->password))
                    {
                        if($request->new_password == $request->confirm_password)
                        {
                            $user->update([
                                'password' => Hash::make($request->new_password),
                            ]);
                            $token = JWTAuth::fromUser($user);
                            $user = new UserResource($user);
                            return response()->json(['data' => $user,'status' => 200]);
                        }
                        else
                        {
                            return response()->json(['data' => __('lang.new_password__confirm_err'),'status' => 422]);
                        }
                    }
                    else
                    {
                        return response()->json(['data' => __('lang.current_password_err'),'status' => 422]);
                    }
                }
                else
                {
                    return response()->json(['data' => __('lang.error_user_data'),'status' => 422]);
                }
        } catch (JWTException $e) {
            return response()->json(['data' => $e->getMessage()], $e->getStatusCode());
        }

    }


    // user update
    public function changeNotificationStatus(changeNotificationRequest $request)
    {
        $user = JWTAuth::user();
        try {
                if(isset($user))
                {
                    $user->update([
                        'notify' => (int)$request->notify,
                    ]);

                    $token = JWTAuth::fromUser($user);
                    $user = new UserResource($user);
                    return response()->json(['data' => $user,'token' => $token ,'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => __('site.error_user_data'),'status' => 422]);
                }
        } catch (JWTException $e) {
            return response()->json(['data' => $e->getMessage()], $e->getStatusCode());
        }

    }



    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }


    // user Certificates
    public function UserCertificate()
    {

        $user = JWTAuth::user();
        try {
                if(isset($user))
                {
                    $subscribes = Subscribe::where(['user_id' => $user->id,'certificate' => 1])->get();
                    return response()->json(['data' => SubscribeResource::collection($subscribes),'status' => 200]);
                }
                else
                {
                    return response()->json(['data' => __('site.error_user_data'),'status' => 422]);
                }
        } catch (JWTException $e) {
            return response()->json(['data' => $e->getMessage()], $e->getStatusCode());
        }

    }

    public function sendVerifyOtp() {
        $user = JWTAuth::user();
        $user->update(['otp' => random_int(10000, 99999)]);
        $Numbers = $user->phone;
        $Originator="Mobile.SA";
        $Message= 'رمز تأكيد الحساب الخاص بك هو: ' . $user->otp;

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
        return response()->json([
            'data' => __('lang.We have sent you a message contain otp code to verify your account'),
            'status' => 200,
        ], 200);
    }

    public function verifyOtp(VerifyOtpRequest $request) {
        if ($request->otp == JWTAuth::user()->otp) {
            auth()->user()->update(['is_verified' => true]);
            return response()->json([
                'data' => __('lang.Account verified successfully'),
                'user' => new UserResource(JWTAuth::user()),
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'data' => __('lang.OTP does not match with what we have sent'),
                'status' => 401,
            ], 401);
        }
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $phone = $request->phone;
        $user =  User::query()->where('phone', $phone)->first();
        $token = random_int(100, 999) . $user->id . random_int(100, 999);
        // $token = random_int(1000, 9999) . $user->id;
        $this->resetPasswordOtp($user, $token);
        return response()->json([
            'data' => __('lang.We have sent you a message contain otp code to reset your password'),
            'reset_token' => $user->code_token,
            'status' => 200
        ]);
    }

    public function verifyResetToken(VerifyResetTokenRequest $request) {
        return response()->json([
            'data' => __('lang.Reset code is right enter new password'),
            'status' => 200
        ]);
    }

    public function verifiedResetToken(VerifiedResetTokenRequest $request) {
        $user = User::query()->where('code', $request->code)->where('code_token', $request->token)->first();
        $user->update([
            'password' => bcrypt($request->password),
            'code' => null,
            'code_token' => null,
        ]);
        return response()->json([
            'data' => __('lang.Password changed successfully'),
            'status' => 200
        ]);
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
