<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'coupon' => 'required|string|min:3|unique:coupons',
            'course_id' => 'required|numeric|min:1',
            'type' => 'required|string|in:free,paid',
            'discount' => 'nullable|numeric|min:1',
            'discount_number' => 'nullable|numeric|min:1',
            'use_number' => 'required|numeric|min:1',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['coupon'] = 'required|string|min:3|unique:coupons,coupon,' . request()->coupon_id;
            $rules['course_id'] = 'required|numeric|min:1';
            $rules['type'] = 'required|string|in:free,paid';
            $rules['discount'] = 'nullable|numeric|min:1';
            $rules['discount_number'] = 'nullable|numeric|min:1';
            $rules['use_number'] = 'required|numeric|min:1';
        }
        return $rules;
    }
}
