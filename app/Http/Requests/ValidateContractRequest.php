<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateContractRequest extends FormRequest
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
            'date_contract'    => 'required',
            'name_manager'     => 'required',
            'name_email'       => 'required|email:rfc,dns',
//            'name_cty'         => 'required',
            'addres_cty'       => 'required',
//            'stk_contract'     => 'required',
//            'search'           => 'required',
            'business_name.*'  => 'required|min:1|string',
            'phone_contract.*' => 'required|numeric|digits:10',
            'email_contract.*' => 'required|min:1|string|email',
            //'email_contract.*' => 'required|min:1|string|email|email:rfc,dns',
            'files.*'          => 'mimes:pdf|max:5012'
        ];

    }

    /**
     * @return string[]
     */
    function messages()
    {
        return [
            'date_contract.required'    => 'Ngày hợp đồng không được để trống',
            'name_manager.required'     => 'Tên giám đốc không được để trống',
            'name_email.required'       => 'Địa chỉ email không được để trống',
            'name_email.email'          => 'Email của người tạo hợp đồng không đúng định dạng',
            'name_cty.required'         => 'Tên CTY không được để trống',
            'addres_cty.required'       => 'Địa chỉ CTY không được để trống',
//            'stk_contract.required'     => 'Số tài khoản không được để trống',
//            'search.required'           => 'Ngân hàng không được để trống',
            'business_name.*.required'  => 'Tên cá nhân, công ty , doanh nghiệp , không được để trống',
            'phone_contract.*.required' => 'Số điện thoại không được để trống',
//            'phone_contract.*.min'      => 'Số điện thoại không đúng',
            'phone_contract.*.digits'   => 'Số điện thoại không đúng',
            'phone_contract.*.numeric'  => 'Sai định dạng số điện thoại của người nhận',
            'email_contract.*.required' => 'Email không được để trống',
            'email_contract.*.email'    => 'Sai định dạng email của người nhận',
//            'files.mimes'                => 'File tải lên phải là định dạng pdf',
            'files.*.max'               => "File tải lên không quá 5MB",
            'files.*.mimes'             => "File tải lên để ký phải là định dạng PDF",
            //
        ];
    }
}
