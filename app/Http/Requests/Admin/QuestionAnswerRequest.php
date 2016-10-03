<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QuestionAnswerRequest extends FormRequest
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
        $rules = [
            'question_id' => 'required|exists:questions,id,deleted_at,NULL',
        ];

        if ($this->request->get('content')) {
            foreach ($this->request->get('content') as $key => $val) {
                $rules['content.' . $key] = 'required|max:' . config('common.question.max_length_content');
            }
        } else {
            $rules['content'] = 'required';
        }

        $rules['correct'] = 'choice:question_id';
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('admins/question_answers/validations');
        $messages = [
            'question_id.required' => $trans['question_id']['required'],
            'question_id.exists' => $trans['question_id']['exists'],
            'correct.choice' => $trans['correct']['choice'],
        ];

        if ($this->request->get('content')) {
            $indexOfOption = 0;
            foreach ($this->request->get('content') as $key => $val) {
                $indexOfOption += 1;
                $messages['content.' . $key . '.required'] = trans('admins/question_answers/validations.content.required',
                    ['indexOption' => $indexOfOption]);
                $messages['content.' . $key . '.max'] = trans('admins/question_answers/validations.content.max',
                    ['indexOption' => $indexOfOption]);
            }
        } else {
            $messages['content'] = $trans['content']['not_found'];
        }

        return $messages;
    }
}
