<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'image_login' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_register' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_join_us' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_top_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_footer_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'image_fav' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['image_login'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';
            $rules['image_register'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';
            $rules['image_join_us'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';
            $rules['image_top_logo'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';
            $rules['image_footer_logo'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';
            $rules['image_fav'] = 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg,webp';

        }
        return $rules;
    }
}
