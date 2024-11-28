<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'title_ar' => 'required|string|min:3',
            'title_en' => 'required|string|min:3',
            'content_ar' => 'required|string|min:3',
            'content_en' => 'required|string|min:3',
            'image' => 'required|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['title_ar'] = 'required|string|min:3';
            $rules['title_en'] = 'required|string|min:3';
            $rules['content_ar'] = 'required|string|min:3';
            $rules['content_en'] = 'required|string|min:3';
            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }
}
