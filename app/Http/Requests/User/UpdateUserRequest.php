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
            'password' => 'string',
            'email' => 'required|string',
            'role'=>'string',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'You need to specify a name',
            'password.string' => 'password must be a string',
            'email.required' => 'You need to specify a email',
            'role.string' => 'role must be a string'
        ];
    }
}
