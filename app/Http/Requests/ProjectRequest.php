<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'project_name' => 'required|string',
            'description' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'project_name.required' => 'You need to specify a project name',
            'description.required' => 'You need to specify a description'
        ];
    }
}
