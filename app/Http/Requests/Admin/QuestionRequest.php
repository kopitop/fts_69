<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $types = implode(",", array_values(config('common.question.type_question')));
        return [
            'subject_id' => 'required|exists:subjects,id,deleted_at,NULL',
            'type' => 'required|in:' . $types,
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
        $trans = trans('admins/questions/validations');
        return [
            'subject_id.required' => $trans['subject_id']['required'],
            'subject_id.exists' => $trans['subject_id']['exists'],
            'type.required' => $trans['type']['required'],
            'type.in' => $trans['type']['in'],
            'content.required' => $trans['content']['required'],
            'content.max' => $trans['content']['max'],
        ];
    }
}
