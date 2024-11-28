<?php

namespace App\Http\Controllers\Api\Account;

use App\Models\User;
use App\Models\About;
use App\Mail\mailPassword;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AboutResource;
use App\Http\Requests\Account\AccountDelete;
use App\Http\Requests\Account\changePassword;
use App\Http\Requests\Account\createNewPassword;

class AccountController extends Controller
{
    public function accountDelete(AccountDelete $request)
    {
        $user = JWTAuth::user();
        try
        {
            if($user)
            {
                if (Hash::check($request->password, $user->password)) {
                   $user->delete();
                   return response()->json(['data' => __('lang.deleted'),'status' => 200]);
                }
            }
            return response()->json(['data' => __('lang.user_not_exist'),'status' => 400]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }

    public function changePassword(changePassword $request)
    {
        $user = User::where(['email' => $request->email])->first();
        try
        {
            if($user)
            {
                $user->update(['code' => rand(10000,99999)]);

                \Mail::to($user->email)->send(new mailPassword($user->code));
                return response()->json(['data' => __('lang.code_sent'),'status' => 200]);
            }
            return response()->json(['data' => __('lang.user_not_exist'),'status' => 400]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
    public function createNewPassword(createNewPassword $request)
    {
        $user = User::where(['email' => $request->email])->first();
        try
        {
            if($user)
            {
                if($user->code == $request->code)
                {
                    $user->update(['password' => bcrypt($request->password)]);
                    return response()->json(['data' => __('lang.updated'),'status' => 200]);

                }
                else
                {
                    return response()->json(['data' => __('lang.code_error'),'status' => 400]);
                }
            }
            return response()->json(['data' => __('lang.user_not_exist'),'status' => 400]);

        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
