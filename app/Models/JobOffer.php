<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class JobOffer extends Model
{
     use HasFactory;

    protected $fillable = [
        'entreprise_id',
        'titre',
        'equipe',
        'secteur',
        'description',
        'type_contrat',
        'date_limite',
        'salaire',
        'devise',
        'periode_salaire',
        'experience_requise',
        'statut',
        'teletravail',
    ];

    protected $casts = [
        'date_limite' => 'datetime', // Laravel gérera l'objet Carbon automatiquement
        'teletravail' => 'boolean',
    ];
 


    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    // Exemple d'accès à un champ formaté
    public function getSalaireFormatAttribute()
    {
        if ($this->salaire) {
            return number_format($this->salaire, 0, ',', ' ') . ' ' . strtoupper($this->devise ?? '');
        }
        return 'Non précisé';
    }
}
