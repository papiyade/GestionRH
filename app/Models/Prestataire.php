<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestataire extends Model
{
    use HasFactory;

    protected $fillable = ['entreprise_id', 'nom', 'prenom', 'email', 'type_contrat'];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function prestations()
    {
        return $this->hasMany(Prestation::class);
    }

    // Calcul du total du mois pour le prestataire
    public function montantTotal($mois, $annee)
    {
        return $this->prestations()
                    ->whereYear('date', $annee)
                    ->whereMonth('date', $mois)
                    ->sum('montant');
    }
}
