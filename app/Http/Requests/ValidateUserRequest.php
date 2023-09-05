<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUserRequest extends FormRequest
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
            'name_add'              => 'required',
            'email_add'             => 'required|email|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'department_add.*'      => 'required|min:1'
            //            'role' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name_add.required'              => 'Họ và tên không được để trống',
            'email_add.required'             => 'Email không dược để trống',
            'email_add.unique'               => 'Email này đã có người sử dụng',
            'email_add.email'                => 'Bạn nhập email không đứng định dạng',
            'password.required'              => 'Mật khẩu không được để trống',
            'password.min'                   => 'Mật khẩu phải lớn hơn 8 ký tự',
            'password.confirmed'             => 'Nhập lại mật khẩu không trùng khớp',
            'password_confirmation.required' => 'Nhập lại mật khẩu không chính xác',
            'password_confirmation.min'      => 'Nhập phải mật khẩu phải lớn hơn 8 ký tự',
            'department_add.*.required'      => 'Phòng ban không được để trống',
            'email_add.regex'                => 'Bạn nhập sai định dạng Email'

            //            'role.required' => 'Nhóm quyền không được để trống'
        ];
    }
}
