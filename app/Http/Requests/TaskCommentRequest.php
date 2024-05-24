<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskCommentRequest extends FormRequest
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
            'comment' => 'required|string',
            'commented_by_user_id' => 'required',
            'task_branch_name' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'comment.required' => 'You need to specify a comment',
            'commented_by_user_id.required' => 'You need to specify a commented by user id',
            'task_branch_name.required' => 'You need to specify a task id'
        ];
    }
}
