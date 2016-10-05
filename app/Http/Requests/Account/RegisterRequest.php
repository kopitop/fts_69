<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:' . $config['max_length_name'],
            'email' => 'required|email|unique:users,email,NULL,deleted_at',
            'chatwork_id' => 'required',
            'password' => 'required|confirmed|max:' . $config['max_length_password'],
            'avatar' => 'file|image|max:' . $config['max_capacity_avatar'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $trans = trans('accounts/registers/validations');
        return [
            'name.required' => $trans['name']['required'],
            'name.max' => $trans['name']['max'],
            'email.required' => $trans['email']['required'],
            'email.email' => $trans['email']['email'],
            'email.unique' => $trans['email']['unique'],
            'chatwork_id.required' => $trans['chatwork_id']['required'],
            'password.required' => $trans['password']['required'],
            'password.confirmed' => $trans['password']['confirmed'],
            'password.max' => $trans['password']['max'],
            'avatar.file' => $trans['avatar']['file'],
            'avatar.image' => $trans['avatar']['image'],
            'avatar.max' => $trans['avatar']['max'],
        ];
    }
}
