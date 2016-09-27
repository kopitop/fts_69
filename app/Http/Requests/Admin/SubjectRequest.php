<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubjectRequest extends FormRequest
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
            'name' => 'required|max:' . config('common.subject.max_length_name'),
            'duration' => 'required|numeric',
            'number_question' => 'required|numeric',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('admins/subjects/validations');
        return [
            'name.required' => $trans['name']['required'],
            'name.max' => $trans['name']['max'],
            'duration.required' => $trans['duration']['required'],
            'duration.numeric' => $trans['duration']['numeric'],
            'number_question.required' => $trans['number_question']['required'],
            'number_question.numeric' => $trans['number_question']['numeric'],
        ];
    }
}
