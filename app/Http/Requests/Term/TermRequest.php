<?php

namespace App\Http\Requests\Term;

use Illuminate\Foundation\Http\FormRequest;

class TermRequest extends FormRequest
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
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['title_ar'] = 'required|string|min:3';
            $rules['title_en'] = 'required|string|min:3';
            $rules['content_ar'] = 'required|string|min:3';
            $rules['content_en'] = 'required|string|min:3';

        }
        return $rules;
    }
}
