<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telephone',
        'workstatus',
        'photo_profile_path',
        'last_login_at',
        'entreprise_id',
    ];

// L'entreprise que cet utilisateur a créée (optionnel, utile si tu veux savoir qui est le fondateur)
public function entrepriseCreee()
{
    return $this->hasOne(Entreprise::class, 'user_id'); // user_id dans la table entreprises
}

// L'entreprise à laquelle il appartient
public function entreprise()
{
    return $this->belongsTo(Entreprise::class, 'entreprise_id'); // entreprise_id dans la table users
}
public function teams()
{
    return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
}


public function employeeDetail()
{
    return $this->hasOne(EmployeeDetail::class);
}
public function employeeDocuments()
{
    return $this->hasMany(EmployeeDocument::class, 'user_id');
}



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
