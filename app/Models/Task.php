<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\TaskComment;
use App\Models\User;
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_title',
        'status',
        'branch_name',
        'reporter_user_id',
        'assignee_user_id',
        'description',
        'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function taskCommets()
    {
        return $this->hasMany(TaskComment::class);
    }
    public function reporterUser()
    {
        return $this->hasOne(User::class, 'reporter_user_id', 'id');
    }
    public function asigneeUser()
    {
        return $this->hasOne(User::class, 'assignee_user_id', 'id');
    }
}
