<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    //
      protected $fillable = [
        'id_user',
        'logo_path',
        'adresse',
        'entreprise_name',
        'email',
        'description',
        'is_actif',
        
    ];

// Le créateur de l'entreprise
public function createur()
{
    return $this->belongsTo(User::class, 'user_id'); // user_id dans la table entreprises
}

// Tous les utilisateurs qui appartiennent à cette entreprise
public function users()
{
    return $this->hasMany(User::class, 'entreprise_id'); // entreprise_id dans la table users
}

public function teams()
{
    return $this->hasMany(Team::class);
}

public function projects()
{
    return $this->hasMany(Project::class);
}





}
