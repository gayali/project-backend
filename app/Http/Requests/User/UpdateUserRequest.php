<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'password' => 'required|string',
            'email' => 'required|unique:users|string'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'You need to specify a name',
            'password.required' => 'You need to specify a password',
            'password.string' => 'password must be a string',
            'email.required' => 'You need to specify a email',
        ];
    }
}
