<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'task_title' => 'required|string',
            'reporter_user_id' => 'required|integer',
            'assignee_user_id' => 'required|integer',
            'description' => 'required|string',
            'project_id' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'task_title.required' => 'You need to specify a Task Title',
            'reporter_user_id.required' => 'You need to specify a reporter user',
            'assignee_user_id.required' => 'You need to specify a assignee user',
            'description.required' => 'You need to specify a description',
            'project_id.required' => 'You need to specify a project id',
        ];
    }
}
