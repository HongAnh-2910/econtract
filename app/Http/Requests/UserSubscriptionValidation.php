<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSubscriptionValidation extends FormRequest
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
            'business_name'     => 'required',
            'business_alias'    => 'required',
            'tax_code'          => 'required',
            'duration_package'  => 'required|integer',
            'last_name'         => 'required',
            'first_middle_name' => 'required',
            'email'             => 'required|email',
            'phone_number'      => 'required|numeric|digits:10',
            'birthday'          => 'required|date',
            'gender'            => 'required|integer',
            'address'           => 'required',
        ];
    }

    /**
     * @return string[]
     */
    function messages()
    {
        return [
            'business_name.required'     => 'Tên doanh nghiệp không được để trống',
            'business_alias.required'    => 'Tên viết tắt không được để trống',
            'tax_code.required'          => 'Mã số thuế không được để trống',
            'duration_package.required'  => 'Thời hạn gói không được để trống',
            'last_name.required'         => 'Họ không được để trống',
            'first_middle_name.required' => 'Tên và đệm không được để trống',
            'email.required'             => 'Email không được để trống',
            'phone_number.required'      => 'Số điện thoại không được để trống',
            'birthday.required'          => 'Ngày sinh không được để trống',
            'gender.required'            => 'Giới tính không được để trống',
            'address.required'           => 'Địa chỉ không được để trống',

            'duration_package.integer'   => 'Thời hạn gói phải là số(năm)',
            'email.email'                => 'Email không đúng định dạng',
            'birthday.date'              => 'Ngày sinh không đúng',
            'phone_number.numberic'      => 'Số điện thoại không đúng',
            'phone_number.digits'        => 'Số điện thoại không đúng',
            'gender.integer'             => 'Giới tính đang bị lỗi'


        ];
    }
}
