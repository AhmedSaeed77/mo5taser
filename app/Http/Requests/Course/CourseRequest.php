<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'desc_ar' => 'required|string|min:3',
            'desc_en' => 'required|string|min:3',
            'course_bag' => 'required|string|min:3',
            'course_table' => 'required|string|min:3',
            'peroid' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|numeric|min:1',
            'price_after' => 'nullable|numeric|min:1',
            'subscribers' => 'required|integer|gte:0',
            'active' => 'required|string',
            'type' => 'required|string|min:3',
            'preview_video' => 'required|string|min:3',
            'preview_video_platform' => 'required|in:youtube,vimeo',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];
        return $rules;
    }
}
