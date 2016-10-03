<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAnswerEditRequest extends FormRequest
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
            'question_id' => 'required|exists:questions,id,deleted_at,NULL',
            'content' => 'required|max:' . config('common.question.max_length_content'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('admins/question_answers/validations');
        return [
            'question_id.required' => $trans['question_id']['required'],
            'question_id.exists' => $trans['question_id']['exists'],
            'content.required' => trans('admins/question_answers/validations.content.required', ['indexOption' => 'current']),
            'content.max' => trans('admins/question_answers/validations.content.max', ['indexOption' => 'current']),
        ];
    }
}
