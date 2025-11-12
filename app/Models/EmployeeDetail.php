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
    'banque_nom',
    'iban',
    'bic_swift',
    'numero_compte',
    'type_compte',
    'nom_titulaire',
    'sursalaire',
    // Rubriques soumises
    'ipres_salariale',
    'ipres_patronale',
    'ipresc_salariale',
    'ipresc_patronale',
    'caisse_css',
    'accident_travail',
    'prestation_famille',
    'ipm_assurance',
    'ir',
    'trimf',
    'cfce',
];


    /**
     * Relation avec le modèle User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSalaireAttribute($value)
    {
        // Si le salaire dans employee_detail est défini, on le prend, sinon on prend le dernier salaire RH
        if (! empty($value)) {
            return $value;
        }

        // Chercher le dernier salaire de l'employé lié à l'utilisateur
        $user = $this->user;
        if ($user && $user->employee && $user->employee->salaires()->latest('date_effet')->first()) {
            return $user->employee->salaires()->latest('date_effet')->first()->salaire_base;
        }

        return 0; // défaut si rien
    }

    public function getRubriquesSoumises()
    {
        return [
            'IPRES (part salariale)' => $this->ipres_salariale,
            'IPRES (part patronale)' => $this->ipres_patronale,
            'IPRES Complémentaire (salariale)' => $this->ipresc_salariale,
            'IPRES Complémentaire (patronale)' => $this->ipresc_patronale,
            'CSS' => $this->caisse_css,
            'Accident du travail' => $this->accident_travail,
            'Prestation de famille' => $this->prestation_famille,
            'IPM (Assurance)' => $this->ipm_assurance,
            'IR' => $this->ir,
            'TRIMF' => $this->trimf,
            'CFCE' => $this->cfce,
        ];
    }

public function getRubriquesNonSoumises()
{
    return [
        'Indemnité transport' => $this->entreprise->indemnite_transport ?? 0,
    ];
}


    public function getRubriquesSalaire()
    {
        return [
            'Salaire de base' => $this->salaire,
            'Sursalaire' => $this->sursalaire,
            'Indemnité' => $this->indemnite,
        ];
    }

    public function getSalaireBrutAttribute()
    {
        return $this->salaire + ($this->sursalaire ?? 0) + ($this->indemnite ?? 0);
    }

    public function getTotalDeductionsAttribute()
    {
        // Exemple simple basé sur les taux connus
        $ipres = ($this->salaire * ($this->ipres_salariale / 100));
        $css = ($this->salaire * ($this->caisse_css / 100));
        $ir = $this->ir ?? 0;
        $trimf = $this->trimf ?? 0;

        return $ipres + $css + $ir + $trimf;
    }

    public function getSalaireNetAttribute()
    {
        return $this->salaire_brut - $this->total_deductions;
    }
    public function entreprise()
{
    return $this->user->entreprise ?? null;
}

}
