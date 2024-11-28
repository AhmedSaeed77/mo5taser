<?php

namespace App\Http\Requests\Testimonail;

use Illuminate\Foundation\Http\FormRequest;

class TestimonailRequest extends FormRequest
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
            'comment_ar' => 'required|string|min:3',
            'comment_en' => 'required|string|min:3',
            'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['comment_ar'] = 'required|string|min:3';
            $rules['comment_en'] = 'required|string|min:3';
            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }
}
