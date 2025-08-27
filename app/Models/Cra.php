<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cra extends Model
{
        use HasFactory;

    protected $fillable = [
        'date_debut',
        'date_fin',
        'activites',
        'commentaires',
        'user_id',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}


}
