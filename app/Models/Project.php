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


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
