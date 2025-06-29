<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    //
    protected $table = 'employee_details';

    protected $fillable = [
        'user_id',
        'matricule',
        'salaire',
        'type_contrat',
        'description_poste',
        'date_naissance',
        'date_debut',
        'date_fin',
        'adresse',
        'telephone',
        'statut_employe',
        'genre',
        'ville',
        'nationalite',
        'niveau_etude',
        'experience',
    ];

    /**
     * Relation avec le modèle User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
