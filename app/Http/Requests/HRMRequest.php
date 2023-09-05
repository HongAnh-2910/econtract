<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HRMRequest extends FormRequest
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
            'email' => 'required',

            'gender' => 'required',
            'phone_number' => 'required|numeric',
            'date_start' => 'required',
            'department_id' => 'required',
            'form' => 'required',
            'date_of_birth' => 'required',
            'passport' => 'required',
            'date_range' => 'required',
            'place_range' => 'required',
            'permanent_address' => 'required',
            'current_address' => 'required',
            'account_number' => 'required',
            'name_account' => 'required',
            'name_bank' => 'required',
            'motorcycle_license_plate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'                  => 'Họ và tên không được để trống',
            'name.required'                 => 'Họ và tên này đã có người sử dụng',
            'email.required'                 => 'Email không dược để trống',
            'email.unique'                   => 'Email này đã có người sử dụng',

            'gender.required'        => 'Giới tính không được để trống',

            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.regex' => 'Số điện thoại không đúng định dạng',
            'phone_number.unique' => 'Số điện thoại đã có người sử dụng',
            'phone_number.numeric' => 'Số điện thoại không đúng định dạng',

            'date_start.required'        => 'Ngày bắt đầu không được để trống',
            'department_id.required' => 'Phòng ban không được để trống',
            'form.required'        => 'Hình thức không được để trống',
            'date_of_birth.required' => 'Sinh ngày không được để trống',
            'passport.required'        => 'Số CMND/Hộ chiếu không được để trống',
            'date_range.required' => 'Ngày cấp không được để trống',
            'place_range.required'        => 'Nơi cấp không được để trống',
            'permanent_address.required' => 'Địa chỉ thường chú không được để trống',
            'current_address.required'        => 'Địa chỉ hiện tại không được để trống',
            'account_number.required' => 'Số tài khoản không được để trống',
            'name_account.required'        => 'Tên tài khoản không được để trống',
            'name_bank.required'        => 'Tên ngân hàng không được để trống',
            'motorcycle_license_plate.required' => 'Biển số xe không được để trống',
        ];
    }
}
