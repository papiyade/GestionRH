<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    //
     protected $fillable = [ 
        'name',
        'description',
        'owner_id',
        'entreprise_id'
     ];

      public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

     public function members(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
}
public function projects()
{
    return $this->hasMany(Project::class);
}

}
