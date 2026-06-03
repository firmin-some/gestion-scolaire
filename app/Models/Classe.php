<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = [
        'nom', 'niveau', 'enseignant', 'frais'
    ];

    // Une classe a plusieurs élèves
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function enseignants()
    {
        return $this->hasMany(Enseignant::class);
    }
}