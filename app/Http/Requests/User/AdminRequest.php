<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins',
            'phone' => 'required|numeric',
            'password' => 'required|string|min:8',
            'active' => 'required|numeric',
            'subject' => 'nullable|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['name'] = 'required|string|min:3';
            $rules['email'] = 'required|email|unique:admins,email,' . request()->admin;
            $rules['phone'] = 'required|unique:admins,phone,' . request()->admin;
            $rules['password'] = 'sometimes|nullable|string:min:8';
            $rules['active'] = 'nullable|numeric';
            $rules['subject'] = 'nullable|string';
            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }
}
