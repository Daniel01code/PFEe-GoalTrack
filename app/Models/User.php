<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'service_id', 
        'chef_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
    ];
// Relation : un utilisateur appartient à un service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Relation : un utilisateur (employé) a un chef (direct)
    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id');
    }

    // Relation inverse : un chef a plusieurs employés
    public function employes()
    {
        return $this->hasMany(User::class, 'chef_id');
    }

    // Relation : un employé a plusieurs rapports
    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'user_id');
    }

    // Relation : un employé a plusieurs objectifs individuels
    public function objectifsIndividuels()
    {
        return $this->hasMany(ObjectifIndividuel::class, 'user_id');
    }

    // Relation : un chef valide plusieurs rapports (via Validation)
    public function validations()
    {
        return $this->hasMany(Validation::class, 'valideur_id');
    }
}
