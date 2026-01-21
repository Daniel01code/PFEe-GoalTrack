<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectifIndividuel extends Model
{
    use HasFactory;
    protected $fillable = [
        'objectif_global_id', 
        'user_id', 
        'cible_personnelle', 
        'pourcentage_atteinte', 
        'commentaire', 
        'statut'
    ];

    public function objectifGlobal()
    {
        return $this->belongsTo(ObjectifGlobal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
