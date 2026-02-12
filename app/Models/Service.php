<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
        'is_deleted',
    ];
    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function setMatriculeAttribute($value)
    {
        if (empty($value)) {
            $year = date('Y');
            $last = self::whereYear('created_at', $year)
                ->where('matricule', 'like', "SERV-{$year}-%")
                ->orderBy('matricule', 'desc')
                ->first();

            $number = $last ? (int) substr($last->matricule, -3) + 1 : 1;
            $this->attributes['matricule'] = sprintf("SERV-%d-%03d", $year, $number);
        } else {
            $this->attributes['matricule'] = $value;
        }
    }
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
    // Relation : le chef du service (1 chef par service)
    public function chef()
    {
        return $this->hasOne(User::class, 'service_id')
                    ->where('role', 'chef')
                    ->where('is_deleted', false);
    }
    
}
