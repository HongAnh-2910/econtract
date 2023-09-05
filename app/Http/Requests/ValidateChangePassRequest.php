<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateChangePassRequest extends FormRequest
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
            'pass-old'              => 'required',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
            //
        ];
    }

    public function messages()
    {
        return [
            'pass-old.required'              => 'Nhập lại mật khẩu không được để trống',
            'password.required'              => 'Nhập khẩu mới không được để trống',
            'password.confirmed'             => 'Xác nhận mật khẩu không khớp',
            'password.min'                   => 'Nhập khẩu lớn hơn 8 ký tự',
            'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống'
            //
        ];
    }
}
