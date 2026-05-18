<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Paiement;

class DashboardController extends Controller
{
   public function index()
{
    $totalEleves   = Eleve::count();
    $totalClasses  = Classe::count();

    // Frais attendu = somme des frais de chaque élève selon sa classe
    $fraisAttendu  = 0;
    Eleve::with('classe')->get()->each(function($e) use (&$fraisAttendu) {
        $fraisAttendu += (int)($e->classe->frais ?? 0);
    });

    $fraisCollecte = (int) Paiement::sum('montant');
    $tauxCollecte  = $fraisAttendu > 0
                        ? round($fraisCollecte / $fraisAttendu * 100)
                        : 0;

    $elevesImpayes = Eleve::with('classe','paiements')
                        ->get()
                        ->filter(fn($e) => $e->resteAPayer() > 0);

    $classes = Classe::with('eleves.paiements')->get();

    return view('dashboard', compact(
        'totalEleves','totalClasses','fraisAttendu',
        'fraisCollecte','tauxCollecte','elevesImpayes','classes'
    ));
}
}