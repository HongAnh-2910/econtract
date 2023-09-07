<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class StoreProposalRequest extends FormRequest
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
            'user_id' => 'required'
        ];
    }

    /**
     * @return array
     */

    public function messages()
    {
        return [
            'required' => ':Attribute không được để trống',
        ];
    }

    /**
     * @return string[]
     */

    public function attributes()
    {
        return [
            'user_id' => 'Người kiểm duyệt'
        ];
    }
}
