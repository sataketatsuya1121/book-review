<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookReviewRequest extends FormRequest
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
            'evaluation' => 'min:0|max:5',
            'content' => 'required|max:1000',
            'ISBN' => Rule::unique('reviews')->where('user_id', Auth::id()),
        ];
    }

    public function messages()
    {
        return [
            'required' => '入力必須の項目です。',
            'evaluatuion.min' => '0~5で評価してください。',
            'evaluatuion.max' => '0~5で評価してください。',
            'content.max' => ':max字以内で記述してください。',
        ];
    }
}
