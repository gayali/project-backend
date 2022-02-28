<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'project_id'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
