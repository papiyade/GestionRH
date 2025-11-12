<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cra extends Model
{
        use HasFactory;
            protected $table = 'cras';

    protected $fillable = [
        'date_debut',
        'date_fin',
        'activites',
        'bien_fonctionne',
        'pas_bien_fonctionne',
        'points_durs',
        'next_steps',
        'commentaires',
        'user_id',
        'team_id',
    ];
        protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
    /**
     * Relation: Un CRA peut appartenir à une équipe (optionnel)
     */
public function team()
{
    return $this->belongsTo(Team::class);
}


    /**
     * Scope: Filtrer par utilisateur
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

         /** Scope: Filtrer par équipe
     */
    public function scopeByTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    /**
     * Scope: Filtrer par date
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_debut', [$startDate, $endDate]);
    }
        /**
     * Scope: Cette semaine
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('date_debut', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    /**
     * Scope: Ce mois
     */
    public function scopeThisMonth($query)
    {
        return $query->whereBetween('date_debut', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ]);
    }
        /**
     * Retourne le numéro de la semaine ISO
     */
    public function getWeekNumberAttribute()
    {
        return $this->date_debut->isoWeek;
    }

    /**
     * Retourne le texte de la période
     */
    public function getPeriodAttribute()
    {
        return $this->date_debut->format('d M Y') . ' - ' . $this->date_fin->format('d M Y');
    }
        /**
     * Vérifie si le CRA est complété
     */
    public function isComplete()
    {
        return !empty($this->activites) && 
               !empty($this->bien_fonctionne) && 
               !empty($this->pas_bien_fonctionne) && 
               !empty($this->points_durs) && 
               !empty($this->next_steps);
    }

        /**
     * Retourne le pourcentage de complétude
     */
    public function getCompletion()
    {
        $fields = [
            'activites',
            'bien_fonctionne',
            'pas_bien_fonctionne',
            'points_durs',
            'next_steps',
            'commentaires',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        return (int) ($filled / count($fields) * 100);
    }
}
