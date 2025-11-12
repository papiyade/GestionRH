<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'prenom',
        'nom',
        'adresse',
        'date_naissance',
        'lieu_naissance',
        'residence_actuelle',
        'certificat_residence',
        'photocopie_identite',
        'extrait_naissance',
        'fiche_dotation_materiels',
        'telephone',
        'email',
        'certificat_mariage',
        'extraits_naissance_enfants',
        'fiche_poste',
        'statut',
        'entreprise_id',
        'user_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'extraits_naissance_enfants' => 'array',
    ];

    public function salaire()
    {
        return $this->hasOne(Salaire::class)->latestOfMany();
    }

    public function salaires()
    {
        return $this->hasMany(Salaire::class);
    }

    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

public function entreprise()
{
    return $this->belongsTo(Entreprise::class, 'entreprise_id');
}


}
