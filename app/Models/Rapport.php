<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'periode_id', 
        'statut', 
        'contenu', 
        'pourcentage_atteinte', 
        'date_soumission'
    ];

    protected $casts = [
        'contenu' => 'array',
        'date_soumission' => 'datetime',
    ];
// Relation : rapport appartient à un employé
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation : rapport appartient à une période
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    // Relation : un rapport peut avoir une validation
    public function validation()
    {
        return $this->hasOne(Validation::class, 'rapport_id');
    }
}
