<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SprintRequest extends FormRequest
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
            'name' => 'required|string'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'You need to specify a sprint name',
            'name.string' => 'Sprint name must be string',
        ];
    }
}
