<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
     protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'project_id', // Si une tâche appartient à un projet
    ];

      public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
                    ->withTimestamps();
    }

      public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
