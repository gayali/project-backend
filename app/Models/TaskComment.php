<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
class TaskComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'commented_by_user_id',
        'task_id',
    ];
    protected $with = [
        'user',
        'task'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'commented_by_user_id','id');
    }

}
