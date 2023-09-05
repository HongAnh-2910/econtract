<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUserHRMRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'form' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'                  => 'Họ và tên không được để trống',
            'name.unique'                 => 'Họ và tên này đã có người sử dụng',
            'email.required'                 => 'Email không dược để trống',
            'email.unique'                   => 'Email này đã có người sử dụng',
            'form.required'                  => 'Hình thức này không dược để trống'
        ];
    }
}
