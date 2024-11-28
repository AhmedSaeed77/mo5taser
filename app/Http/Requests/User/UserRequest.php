<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email|unique:admins,email',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8',
            'active' => 'nullable|numeric',
            'educational_level' => 'nullable|string|min:3|max:255',
            'level' => 'nullable|string|min:3|max:255',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {

            if(!$this->isFrontEnd(request()))
            {
              $user = JWTAuth::user();
            }
            else
            {
                $user = User::findOrFail(request()->user);
            }
            $rules['name'] = 'nullable|string|min:3|max:255';
            $rules['email'] = 'nullable|email|unique:users,email,' . $user->id.'|unique:admins,email,' . $user->id;
            $rules['phone'] = 'nullable|unique:users,phone,' . $user->id;
            $rules['password'] = 'nullable|string:min:8';
            $rules['active'] = 'nullable|numeric';
            $rules['educational_level'] = 'nullable|string|min:3|max:255';
            $rules['level'] = 'nullable|string|min:3|max:255';
            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }

    private function isFrontEnd(Request $request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
