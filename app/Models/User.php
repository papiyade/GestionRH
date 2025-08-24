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

public function entrepriseCreee()
{
    return $this->hasOne(Entreprise::class, 'user_id'); 
}

public function getTeamsInSameEntreprise()
{
    $entrepriseId = $this->entreprise_id;

    if (!$entrepriseId) {
        return collect();
    }

    return Team::with('owner')->withCount('users')->where('entreprise_id', $entrepriseId)->get();
}

public function entreprise()
{
    return $this->belongsTo(Entreprise::class, 'entreprise_id');
}
public function teams()
{
    return $this->belongsToMany(Team::class, 'team_user', 'user_id', 'team_id');
}


public function employeeDetail()
{
    return $this->hasOne(EmployeeDetail::class);
}

  public function employeDetail()
    {
        return $this->hasOne(EmployeeDetail::class);
    }
public function employeeDocuments()
{
    return $this->hasMany(EmployeeDocument::class, 'user_id');
}

 public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }

public function projects()
{
    return $this->belongsToMany(Project::class, 'project_user', 'user_id', 'project_id');
}

public function ownedTeams()
{
    return $this->hasMany(Team::class, 'owner_id');
}
 public function payrollSlips()
    {
        return $this->hasMany(PayrollSlip::class);
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
