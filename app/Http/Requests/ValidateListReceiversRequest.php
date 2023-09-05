<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateListReceiversRequest extends FormRequest
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
            'business_name.*'  => 'required|min:1|string',
            'phone_contract.*' => 'required|min:1|string',
            'email_contract.*' => 'required|min:1|string',
        ];
    }

    public function messages()
    {
        return [
            'business_name.*.required'  => 'Tên cá nhân, công ty , doanh nghiệp , không được để trống',
            'phone_contract.*.required' => 'Điện thoại không được để trống',
            'email_contract.*.required' => 'Email không được để trống',
        ];
    }
}
