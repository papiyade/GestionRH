<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'salaire_base',
        'prime',
        'deductions',
        'date_effet',
    ];

    protected $casts = [
        'date_effet' => 'date',
        'salaire_base' => 'decimal:2',
        'prime' => 'decimal:2',
        'deductions' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getSalaireNetAttribute()
    {
        return $this->salaire_base + $this->prime - $this->deductions;
    }
}