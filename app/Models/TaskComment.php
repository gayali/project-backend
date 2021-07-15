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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
