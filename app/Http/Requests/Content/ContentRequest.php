<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
       // dd(request()->all());
        $rules = [
            'title_ar' => 'required|string|min:3',
            'title_en' => 'required|string|min:3',
            'desc_ar' => 'nullable|string|min:3',
            'desc_en' => 'nullable|string|min:3',
            'live_url' => 'nullable|url',
            'recorded_url' => 'nullable|url',
            'zoom_time' => 'nullable|date|after:now',
            'questions_number' => 'nullable|numeric|min:1',
            'exam_time' => 'nullable|numeric|min:1',
            'attempts_count' => 'nullable|numeric|min:1',
            'sort' => 'nullable|numeric|min:1',
            'type' => 'required|string|min:3',
            'course_id' => 'required|numeric|min:1',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['title_ar'] = 'required|string|min:3';
            $rules['title_en'] = 'required|string|min:3';
            $rules['desc_ar'] = 'nullable|string|min:3';
            $rules['desc_en'] = 'nullable|string|min:3';
            $rules['type'] = 'nullable|string|min:3';
            $rules['live_url'] = 'nullable|url';
            $rules['recorded_url'] = 'nullable|url';
            // $rules['zoom_date'] = 'nullable|date';
            $rules['questions_number'] = 'nullable|numeric|min:1';
            $rules['exam_time'] = 'nullable|numeric|min:1';
            $rules['attempts_count'] = 'nullable|numeric|min:1';
            $rules['sort'] = 'nullable|numeric|min:1';
            $rules['course_id'] = 'nullable|numeric|min:1';

        }
        return $rules;
    }
}
