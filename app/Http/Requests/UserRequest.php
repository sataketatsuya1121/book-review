<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;
use App\Models\UserDetail;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'avatar' => 'file|image',
            'sub_avatar' => 'file|image',
            'name' => 'required|max:20',
            'email' => new EmailRule,
            'birthday' => 'nullable|dete|date_format:Y-m-d',
            'joined_company_date' => 'nullable|date|date_format:Y-m-d',
            'dept_id' => 'nullable|integer',
            'lang_id' => 'nullable|integer',
            'introduce' => 'nullable|string|max:255',

        ];
    }

    public function messages()
    {
        return [
            'required' => '入力必須の項目です。',
            'max' => ':max文字以内で入力して下さい。',
        ];
    }
}
