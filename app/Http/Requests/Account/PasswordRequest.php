<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email,deleted_at,NULL',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('accounts/forgot_passwords/validations');
        return [
            'email.required' => $trans['email']['required'],
            'email.email' => $trans['email']['email'],
            'email.exists' => $trans['email']['exists'],
        ];
    }
}
