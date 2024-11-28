<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'user_account_name' => request()->type == 'by_check' ? 'required|string|min:3' : '',
            'bank_name' => request()->type == 'by_check' ? 'required|string|min:3' : '',
            'transfer_date' => request()->type == 'by_check' ? 'required|date' : '',
            'image' => request()->type == 'by_check' ? 'required|image|mimes:jpeg,png,jpg,gif,svg,webp' : '',
            'type' => 'required|string|in:by_check,visa'
        ];
        return $rules;
    }
}
