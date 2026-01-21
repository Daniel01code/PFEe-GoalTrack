<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectifGlobal extends Model
{
    use HasFactory;
    protected $fillable = [
        'periode_id', 
        'service_id', 
        'description', 
        'cible', 
        'unite'
    ];

// Relation : objectif global appartient à une période
    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id');
    }

    // Relation : objectif global appartient à un service
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Relation : un objectif global a plusieurs objectifs individuels
    public function objectifsIndividuels()
    {
        return $this->hasMany(ObjectifIndividuel::class, 'objectif_global_id');
    }
}
