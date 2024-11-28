<?php

namespace App\Http\Requests\Exams;

use Illuminate\Foundation\Http\FormRequest;

class PassRequest extends FormRequest
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
            'questions_number' => 'required|numeric|min:1',
            'exam_time' => 'required|numeric|min:1',
            'attemps' => 'required|numeric|min:1',
            'teacher_id' => 'required|numeric|min:1',
            'main_cat' => 'required|numeric|min:1',
            'level' => 'required|numeric|min:1',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['questions_number'] = 'required|numeric|min:1';
            $rules['exam_time'] = 'required|numeric|min:1';
            $rules['attemps'] = 'required|numeric|min:1';
            $rules['teacher_id'] = 'required|numeric|min:1';
            $rules['main_cat'] = 'required|numeric|min:1';
            $rules['level'] = 'required|numeric|min:1';

        }
        return $rules;
    }
}
