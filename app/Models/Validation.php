<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;
    protected $fillable = [
        'rapport_id', 
        'valideur_id', 
        'commentaire', 
        'statut', 
        'date_validation'
    ];

    protected $casts = [
        'date_validation' => 'datetime',
    ];

    public function rapport()
    {
        return $this->belongsTo(Rapport::class);
    }

    public function valideur()
    {
        return $this->belongsTo(User::class, 'valideur_id');
    }
}
