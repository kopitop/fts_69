<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
        $config = config('common.user');
        return [
            'password' => 'required|confirmed|max:' . $config['max_length_password'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('accounts/reset_passwords/validations');
        return [
            'password.required' => $trans['password']['required'],
            'password.confirmed' => $trans['password']['confirmed'],
            'password.max' => $trans['password']['max'],
        ];
    }
}
