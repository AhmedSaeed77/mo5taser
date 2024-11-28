<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected function authenticated($request , $user)
    {

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
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        try
        {
            $type = request()->type;
            if($type != null)
            {
                if($type == 'student')
                {
                    return Validator::make($data, [
                        'name' => ['required', 'string','min:3' ,'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'phone' => ['required', 'unique:users'],
                        'educational_level' => ['required', 'string'],
                        'level' => ['required', 'string'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                    ]);
                }
                if($type == 'teacher')
                {
                    return Validator::make($data, [
                        'name' => ['required', 'string','min:3', 'max:255'],
                        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        'phone' => ['required',  'unique:users'],
                        'spec' => ['required', 'string'],
                        'password' => ['required', 'string', 'min:8', 'confirmed'],
                    ]);
                }
                else
                {
                    return back()->with('failed' , __('lang.type_required'));
                }
            }
            else
            {
                return back()->with('failed' , __('lang.type_required'));
            }
    }
    catch(Exception $ex)
    {
        return back()->with('failed' , __('lang.not_found'));
    }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try
        {
            $type = request()->type;
            if($type != null)
            {

                if($type == 'student')
                {
                    $user =  User::create([
                        'name' => $data['name'],
                        'type' => 'student',
                        'phone' => $data['phone'],
                        'email' => $data['email'],
                        'educational_level' => $data['educational_level'],
                        'level' => $data['level'],
                        'role_id' => 4,
                        'code' => rand(10000,99999),
                        'active' => 1,
                        'password' => Hash::make($data['password']),
                    ]);
                    return $user;
                }
                if($type == 'teacher')
                {
                    $user =  User::create([
                        'name' => $data['name'],
                        'type' => 'teacher',
                        'phone' => $data['phone'],
                        'email' => $data['email'],
                        'spec' => $data['spec'],
                        'role_id' => 4,
                        'code' => rand(10000,99999),
                        'active' => 1,
                        'password' => Hash::make($data['password']),
                    ]);
                    return $user;
                }
                else
                {
                    return back()->with('failed' , __('lang.type_required'));
                }
            }
            else
            {
                return back()->with('failed' , __('lang.type_required'));
            }
        }
        catch(Exception $ex)
        {

            return back()->with('failed' , __('lang.not_found'));
        }
    }

    protected function registered(Request $request, $user)
    {
        if($user->active == 0)
        {
            $this->guard()->logout();
            Mail::send('emails.activate_user', [], function ($message) use ($user)
            {
                $message->to($user->email)
                    ->subject('سيتم تفعيل حسابك قريباً');
                $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
            return redirect()->route('home')->withSuccess( __('lang.wait_activation'));
        } else {
            return redirect()->route('home');
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'terms' => 'accepted',
        ]);
        $this->validator($request->all())->validate();

        if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $request->email))
        {
            return back()->with('failed' , __('lang.not_valid_email'))->withInput($request->input());
        }

        if(!preg_match('/^(9665)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/', $request->phone))
        {
            return back()->with('failed' , __('lang.sauid_number'))->withInput($request->input());
        }

        // if(!preg_match('/^(\+966|966)5[0-9]{1}(\s?[0-9]{3}\s?[0-9]{4}\s?[0-9]{0,4})$/', $request->phone))
        // {
        //     return back()->with('failed' , __('lang.sauid_number'))->withInput($request->input());
        // }


        $user = $this->create($request->all());

        if($user instanceof \Illuminate\Foundation\Auth\User ){
            event(new Registered($user));

            $this->guard()->login($user);

            return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());
        }

        return $user;


    }
}
