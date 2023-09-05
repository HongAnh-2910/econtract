<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCustomerRequest extends FormRequest
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
            'name' => 'bail|required|unique:customers,name',
            'phone_number' => 'bail|required|unique:customers,phone_number,',
            'email' => 'bail|required|unique:customers,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '*Tên không được để trống',
            'name.unique' => '*Tên này đã có người sử dụng',
            'phone_number.required' => '*Số điện thoại không được để trống',
            'phone_number.unique' => '*Số điện thoại này đã có người sử dụng',
            'email.required' => '*Email không được để trống',
            'email.unique' => '*Email này đã có người sử dụng',
            'email.email' => '*Bạn nhập email không đứng định dạng',

        ];
    }
}
