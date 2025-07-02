<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Candidature extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'job_offer_id',
        'prenom',
        'nom',
        'email',
        'telephone',
        'linkedin',
        'cv_path',
        'lettre_path',
        'message',
        'disponibilite',
        'pretention',
        'status_demande'
    ];

    public function jobOffer()
    {
        return $this->belongsTo(JobOffer::class);
    }
}
