<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailRequest extends FormRequest
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
            'joined_company_date' => 'nullable|string|max:255',
            'dept_id' => 'nullable|integer',
            'lang' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'max' => ':max文字以内で入力して下さい。',
        ];
    }
}
