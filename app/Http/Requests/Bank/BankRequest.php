<?php

namespace App\Http\Requests\Bank;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'name_ar' => 'required|string|min:3',
            'name_en' => 'required|string|min:3',
            'account_number' => 'required|string|min:3',
            'iban' => 'required|string|min:3',
        ];

        if (in_array("PUT", request()->route()->methods)) {
            $rules['name_ar'] = 'required|string|min:3';
            $rules['name_en'] = 'required|string|min:3';
            $rules['account_number'] = 'required|string|min:3';
            $rules['iban'] = 'required|string|min:3';
        }
        return $rules;
    }
}
