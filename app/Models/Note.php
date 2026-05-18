<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'eleve_id', 'classe_id', 'matiere', 'trimestre', 'note'
    ];

    // Une note appartient à un élève
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    // Une note appartient à une classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}