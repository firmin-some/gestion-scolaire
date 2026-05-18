<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'eleve_id', 'montant', 'date_paiement', 'mode_paiement'
    ];

    protected $casts = [
        'date_paiement' => 'date',
    ];

    // Un paiement appartient à un élève
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}