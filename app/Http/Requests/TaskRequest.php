<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_title' => 'required|string',
            'reporter_user_id' => 'required|integer',
            'assignee_user_id' => 'required|integer',
            'project_id' => 'required|integer'
        ];
    }
    public function messages()
    {
        return [
            'task_title.required' => 'You need to specify a Task Title',
            'task_title.string' => 'Task Title must be string',
            'reporter_user_id.required' => 'You need to specify a reporter user',
            'reporter_user_id.integer' => 'reporter_user_id must be integer',
            'assignee_user_id.required' => 'You need to specify a assignee user',
            'assignee_user_id.integer' => 'assignee_user_id must be integer',
            'project_id.required' => 'You need to specify a project',
            'start_date.string' => 'Start date must be string',
            'end_date.string' => 'End date must be string',
        ];
    }
}
