<?php

namespace App\Http\Requests\Client;

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
        $config = config('common.user');
        return [
            'password' => 'required|max:' . $config['max_length_password'],
            'password_new' => 'required|confirmed|max:' . $config['max_length_password'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('users/profiles/validations');
        return [
            'password.required' => $trans['password']['required'],
            'password.max' => $trans['password']['max'],
            'password_new.required' => $trans['password_new']['required'],
            'password_new.max' => $trans['password_new']['max'],
            'password_new.confirmed' => $trans['password_new']['confirmed'],
        ];
    }
}
