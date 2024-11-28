<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'question' => 'required|string|min:3',
            'answer1' => 'nullable',
            'answer2' => 'nullable',
            'answer3' => 'nullable',
            'answer4' => 'nullable',
            'true_answer' => 'nullable',
            'subject_id/*' => 'required|numeric|min:1',
            'exam_id' => 'nullable|numeric|min:1',
            'degree' => 'required|numeric|min:1',
            'video_url' => 'nullable|string',
            'type' => 'required|string',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['question'] = 'required|string|min:3';
            $rules['answer1'] = 'nullable';
            $rules['answer2'] = 'nullable';
            $rules['answer3'] = 'nullable';
            $rules['answer4'] = 'nullable';
            $rules['true_answer'] = 'nullable';
            $rules['video_url'] = 'nullable';
            $rules['subject_id/*'] = 'required|numeric|min:1';
            $rules['exam_id'] = 'nullable|numeric|min:1';
            $rules['degree'] = 'required|numeric|min:1';
            $rules['type'] = 'required|string|min:3';
            $rules['image'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }
}
