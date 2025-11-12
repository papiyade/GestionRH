<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'project_id',
        'task_id',
    ];

    protected $casts = [
    'deadline' => 'datetime',
];


    // Priorités disponibles
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_LOW = 'low';

    // Statuts disponibles
    public const STATUS_NOT_STARTED = 'not_started';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';

    public static function priorities()
    {
        return [
            self::PRIORITY_HIGH => 'Haute',
            self::PRIORITY_MEDIUM => 'Moyenne',
            self::PRIORITY_LOW => 'Basse',
        ];
    }

    public static function statuses()
    {
        return [
            self::STATUS_NOT_STARTED => 'Non débuté',
            self::STATUS_IN_PROGRESS => 'En cours',
            self::STATUS_COMPLETED => 'Terminée',
        ];
    }

    public function getPriorityClassAttribute()
    {
        return [
            self::PRIORITY_HIGH => 'danger',
            self::PRIORITY_MEDIUM => 'warning',
            self::PRIORITY_LOW => 'success',
        ][$this->priority] ?? 'secondary';
    }

    public function getStatusClassAttribute()
    {
        return [
            self::STATUS_NOT_STARTED => 'secondary',
            self::STATUS_IN_PROGRESS => 'primary',
            self::STATUS_COMPLETED => 'success',
        ][$this->status] ?? 'light';
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id')
                    ->withTimestamps();
    }


    public function files()
    {
        return $this->hasMany(File::class, 'task_id', 'id'); // task_id sur files
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_id', 'id'); // task_id sur comments
    }

}