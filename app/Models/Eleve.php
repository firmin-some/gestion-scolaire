<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'date_naissance', 'sexe',
        'photo', 'nom_parent', 'telephone_parent', 'classe_id'
    ];

    // Un élève appartient à une classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Un élève a plusieurs paiements
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // Un élève a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Total payé par l'élève
   public function totalPaye()
{
    return (int) $this->paiements()->sum('montant');
}

    // Reste à payer
    public function resteAPayer()
{
    $frais = (int) ($this->classe->frais ?? 0);
    $paye  = $this->totalPaye();
    return max(0, $frais - $paye);
}
}