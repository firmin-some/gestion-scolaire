<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'code',
        'email',
        'telephone',
        'specialite',
        'sexe',
        'date_naissance',
    ];

    /**
     * Relation avec le User (pour la connexion)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}