<?php

namespace App\Http\Requests\Info;

use Illuminate\Foundation\Http\FormRequest;

class InfoRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'address_ar' => 'required|string|min:3',
            'address_en' => 'required|string|min:3',
            'email' => 'required|email|unique:infos',
            'phone' => 'required|numeric',
            'whatsapp' => 'required|numeric',
            'twitter' => 'required|url',
            'instagram' => 'required|url',
            'facebook' => 'required|url',
            'video' => 'required|url',
            'video_platform' => 'required|in:youtube,vimeo',
            'tax_number' => 'required|numeric',
            'tax' => 'nullable|numeric|min:1',
            'min_profit' => 'required|numeric|min:1',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['address_ar'] = 'required|string|min:3';
            $rules['address_en'] = 'required|string|min:3';
            $rules['email'] = 'required|email|unique:infos,email,' . $this->info;
            $rules['phone'] = 'required|numeric';
            $rules['whatsapp'] = 'required|numeric';
            $rules['twitter'] = 'required|url';
            $rules['instagram'] = 'required|url';
            $rules['facebook'] = 'required|url';
            $rules['video'] = 'required|url';
            $rules['video_platform'] = 'required|in:youtube,vimeo';
            $rules['tax_number'] = 'required|numeric';
            $rules['tax'] = 'nullable|numeric|min:1';
            $rules['min_profit'] = 'required|numeric|min:1';

        }
        return $rules;
    }
}
