<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle', 
        'date_debut', 
        'date_fin', 
        'statut'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

// Relation : une période a plusieurs objectifs globaux
    public function objectifsGlobaux()
    {
        return $this->hasMany(ObjectifGlobal::class, 'periode_id');
    }

    // Relation : une période a plusieurs rapports
    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'periode_id');
    }
}
