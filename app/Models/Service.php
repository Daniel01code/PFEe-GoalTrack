<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description'
    ];

// Relation : un service a plusieurs employés
    public function employes()
    {
        return $this->hasMany(User::class, 'service_id');
    }

    // Relation : un service a plusieurs chefs (normalement 1 seul, mais hasMany pour flexibilité)
    public function chefs()
    {
        return $this->hasMany(User::class, 'service_id')->where('role', 'chef');
    }

    // Relation : un service a plusieurs objectifs globaux
    public function objectifsGlobaux()
    {
        return $this->hasMany(ObjectifGlobal::class, 'service_id');
    }
    
}
