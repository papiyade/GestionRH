<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    //

     use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'team_id',
        'entreprise_id',
    ];

     public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Un projet appartient à une entreprise
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

     public function comments()
        {
            return $this->hasMany(Comment::class);
        }

      public function members()
{
    return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
                ->withPivot('is_lead') // Ajoute la colonne pivot
                ->withTimestamps();
}
    public function users()
{
    return $this->belongsToMany(User::class, 'project_user')->withPivot('is_lead');
}

public function lead()
{
    return $this->belongsToMany(User::class, 'project_user')
                ->wherePivot('is_lead', true)
                ->withPivot('is_lead');
}

 public function isLead(User $user = null)
    {
        $user = $user ?? auth()->user();
        if (!$user) {
            return false;
        }
        return $this->members()->where('user_id', $user->id)->wherePivot('is_lead', true)->exists();
    }

  

        
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

      public function files()
    {
        return $this->hasMany(File::class);
    }

    
}
