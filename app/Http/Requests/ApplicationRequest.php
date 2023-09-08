<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            'reason'            => 'bail|required',
            'information_day_1' => 'bail|required',
            'information_day_3' => 'bail|required',
            'description'       => 'bail|required',
            'user_id'           => 'required'
        ];
    }

    public function attributes()
    {
       return [
           'reason'            => 'Lý do',
           'information_day_1' => 'Ca làm 1',
           'information_day_3' => 'Ca làm 2',
           'description'       => 'Mô tả',
           'user_id'           => 'Người kiểm duyệt'
       ];
    }

    public function messages()
    {
        return [
            'required'            => ':attribute không được để trống.',
        ];
    }
}
