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

    public function messages()
    {
        return [
            'reason.*'            => 'Lý do không được để trống.',
            'information_day_1.*' => 'Ca làm không được để trống.',
            'information_day_3.*' => 'Ca làm không được để trống.',
            'description.*'       => 'Mô tả không được để trống.',
            'user_id.required'    => "Người kiểm duyệt không được để trống"
        ];
    }
}
