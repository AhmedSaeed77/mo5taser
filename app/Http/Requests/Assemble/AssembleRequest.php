<?php

namespace App\Http\Requests\Assemble;

use Illuminate\Foundation\Http\FormRequest;

class AssembleRequest extends FormRequest
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
            'content_ar' => 'required|string|min:3',
            'content_en' => 'required|string|min:3',
            'type' => 'required|string|in:book,video',
            'show_flag' => 'required|string|in:store,assemble',
            'category_id' => 'required|numeric|min:1',
            'book_preview' => request()->type == 'book' ? request()->method() == 'POST' ? 'nullable|mimes:pdf' : 'nullable' : 'nullable',
            'book' => request()->type == 'book' ? request()->method() == 'POST' ? 'required|mimes:pdf' : 'nullable' : 'nullable',
            'price' => request()->type == 'book' ? request()->method() == 'POST' ? 'nullable|numeric' : 'nullable': 'nullable',
            'link' => request()->type == 'video' ? request()->method() == 'POST' ? 'required|string' : 'nullable': 'nullable',
            'video_platform' => request()->type == 'video' ? request()->method() == 'POST' ? 'required|in:vimeo,youtube' : 'nullable': 'nullable',
            'image' => request()->method() == 'POST' ? 'required|image|mimes:jpeg,png,jpg,gif,svg,webp' : 'nullable',
        ];
        return $rules;
    }
}
