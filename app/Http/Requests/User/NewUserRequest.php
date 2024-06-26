<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
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
            'name' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
            'email' => 'required|unique:users|string',
            'role'=>'required|string',
            'password_confirmation'=>'required|string',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'You need to specify a name',
            'password.required' => 'You need to specify a password',
            'password.string' => 'password must be a string',
            'email.required' => 'You need to specify a email',
            'role.required' => 'You need to specify a role',
            'password_confirmation.required' => 'You need to specify a confirm password',
        ];
    }
}
