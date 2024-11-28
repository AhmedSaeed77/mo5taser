<?php

namespace App\Http\Requests\Team;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
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
            'name_ar' => 'required|string|min:3',
            'name_en' => 'required|string|min:3',
            'job_ar' => 'required|string|min:3',
            'job_en' => 'required|string|min:3',
            'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['name_ar'] = 'required|string|min:3';
            $rules['name_en'] = 'required|string|min:3';
            $rules['job_ar'] = 'required|string|min:3';
            $rules['job_en'] = 'required|string|min:3';
            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }
}
