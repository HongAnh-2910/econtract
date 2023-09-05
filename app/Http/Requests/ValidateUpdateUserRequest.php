<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUpdateUserRequest extends FormRequest
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
            'name'         => 'required',
            'email'        => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'department.*' => 'required|min:1'
            //
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Họ và tên không được để trống',
            'email.required'        => 'Email không dược để trống',
            'email.email'           => 'Bạn nhập email không đứng định dạng',
            'department.*.required' => 'Phòng ban không được để trống',
            'email.regex'           => 'Bạn nhập sai định dạng Email'
        ];
    }
}
