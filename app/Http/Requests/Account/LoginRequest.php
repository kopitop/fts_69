<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|max:' . config('common.user.max_length_password'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('accounts/logins/validations');
        return [
            'email.required' => $trans['email']['required'],
            'email.email' => $trans['email']['email'],
            'password.required' => $trans['password']['required'],
            'password.max' => $trans['password']['max'],
        ];
    }
}
