<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Task;
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'description',
        'prefix'
    ];

    protected $appends = [
        'current_sprint'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }

    public function getCurrentSprintAttribute()
    {
        return $this->sprints->first( function ($sprint){
            return $sprint->is_active === 1;
        });
    }
}
