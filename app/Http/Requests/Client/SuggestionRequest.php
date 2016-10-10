<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class SuggestionRequest extends FormRequest
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
        $config = config('common.suggestion.max_length_content');
        $optionContent = false;
        $rules = [
            'subject_id' => 'required|exists:subjects,id,deleted_at,NULL',
            'type' => 'required',
            'content' => 'required|max:' . $config,
        ];

        if ($this->request->get('content_text')) {
            foreach ($this->request->get('content_text') as $key => $val) {
                $rules['content_text.' . $key] = 'required|max:' . $config;
                $optionContent = true;
            }
        }

        if ($this->request->get('content_single_choice')) {
            foreach ($this->request->get('content_single_choice') as $key => $val) {
                $rules['content_single_choice.' . $key] = 'required|max:' . $config;
                $optionContent = true;
            }
        }

        if ($this->request->get('content_multiple_choice')) {
            foreach ($this->request->get('content_multiple_choice') as $key => $val) {
                $rules['content_multiple_choice.' . $key] = 'required|max:' . $config;
                $optionContent = true;
            }
        }

        if (!$optionContent) {
            $rules['content_text'] = 'required';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('users/suggestions/validations');
        $messages = [
            'subject_id.required' => $trans['subject']['required'],
            'subject_id.exists' => $trans['subject']['exists'],
            'type.required' => $trans['type']['required'],
            'content.required' => $trans['content']['required'],
            'content.max' => $trans['content']['max'],
        ];

        if ($this->request->get('content_text')) {
            $indexOfOption = 0;
            foreach ($this->request->get('content_text') as $key => $val) {
                $indexOfOption += 1;
                $messages['content_text.' . $key . '.required'] =
                    trans('users/suggestions/validations.content_option.required', ['indexOption' => $indexOfOption]);
                $messages['content_text.' . $key . '.max'] =
                    trans('users/suggestions/validations.content_option.max', ['indexOption' => $indexOfOption]);
            }
        }

        if ($this->request->get('content_single_choice')) {
            $indexOfOption = 0;
            foreach ($this->request->get('content_single_choice') as $key => $val) {
                $indexOfOption += 1;
                $messages['content_single_choice.' . $key . '.required'] =
                    trans('users/suggestions/validations.content_option.required', ['indexOption' => $indexOfOption]);
                $messages['content_single_choice.' . $key . '.max'] =
                    trans('users/suggestions/validations.content_option.max', ['indexOption' => $indexOfOption]);
            }
        }

        if ($this->request->get('content_multiple_choice')) {
            $indexOfOption = 0;
            foreach ($this->request->get('content_multiple_choice') as $key => $val) {
                $indexOfOption += 1;
                $messages['content_multiple_choice.' . $key . '.required'] =
                    trans('users/suggestions/validations.content_option.required', ['indexOption' => $indexOfOption]);
                $messages['content_multiple_choice.' . $key . '.max'] =
                    trans('users/suggestions/validations.content_option.max', ['indexOption' => $indexOfOption]);
            }
        }

        $messages['content_text.required'] = $trans['content_option']['not_found'];
        return $messages;
    }
}
