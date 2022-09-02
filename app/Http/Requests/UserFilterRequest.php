<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFilterRequest extends FormRequest
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

        return [
            'currency' => 'nullable|in:USD,EGP,AED,EUR,SAR',
            'statusCode' => 'nullable|in:1,2,3',
            'paidAmount' => 'nullable|numeric',
            'paymentDateFrom' => 'nullable|date_format:Y-m-d',
            'paymentDateTo' => 'nullable|date_format:Y-m-d',
        ];
    }
}
