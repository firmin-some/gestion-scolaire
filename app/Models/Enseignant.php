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
        'classe_id',
        'statut',
    ];

    protected $appends = [
        'specialite_label',
    ];

    public static function specialiteLabels(): array
    {
        return [
            'toutes-matieres' => 'Toutes matières',
            'francais' => 'Français',
            'mathematiques' => 'Mathématiques',
            'histoire-geographie' => 'Histoire-Géo',
            'education civique' => 'Education civique',
            'observation' => 'Observation',
            'anglais' => 'Anglais',
            'sport' => 'Sport',
        ];
    }

    public function getSpecialiteLabelAttribute(): string
    {
        return static::specialiteLabels()[$this->specialite] ?? $this->specialite;
    }

    /**
     * Relation avec le User (pour la connexion)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}