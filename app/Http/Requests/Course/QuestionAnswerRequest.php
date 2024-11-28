<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAnswerRequest extends FormRequest
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
            'question_ar' => 'required|string|min:3',
            'question_en' => 'required|string|min:3',
            'answer_ar' => 'required|string|min:3',
            'answer_en' => 'required|string|min:3',
        ];
        return $rules;
    }
}
