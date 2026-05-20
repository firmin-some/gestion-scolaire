<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'sexe',
        'photo', 'nom_parent', 'telephone_parent',
        'classe_id', 'parent_id'
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function totalPaye()
    {
        return (int) $this->paiements()->sum('montant');
    }

    public function resteAPayer()
    {
        $frais = (int) ($this->classe->frais ?? 0);
        return max(0, $frais - $this->totalPaye());
    }
}