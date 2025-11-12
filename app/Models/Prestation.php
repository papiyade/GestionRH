<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    use HasFactory;

    protected $fillable = ['prestataire_id', 'date', 'montant', 'description'];

    public function prestataire()
    {
        return $this->belongsTo(Prestataire::class);
    }
}

