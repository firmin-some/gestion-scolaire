<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Paiement;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        if ($user->hasRole('Parent')) {
            return redirect()->route('parent.dashboard');
        }

        $totalEleves  = Eleve::count();
        $totalClasses = Classe::count();

        $parents       = collect();
        $totalParents  = 0;
        $fraisAttendu  = 0;
        $fraisCollecte = 0;
        $tauxCollecte  = 0;
        $elevesImpayes = collect();
        $classes       = Classe::with('eleves.paiements')->get();

        // Infos financières : Gestionnaire uniquement
        if ($user->hasRole('Gestionnaire')) {
            $parents = User::role('Parent')
                           ->withCount('eleves')
                           ->has('eleves')
                           ->get();
            $totalParents = $parents->count();

            Eleve::with('classe')->get()->each(function($e) use (&$fraisAttendu) {
                $fraisAttendu += (int)($e->classe->frais ?? 0);
            });

            $fraisCollecte = (int) Paiement::sum('montant');
            $tauxCollecte  = $fraisAttendu > 0
                                ? round($fraisCollecte / $fraisAttendu * 100)
                                : 0;

            $elevesImpayes = Eleve::with('classe', 'paiements')
                                  ->get()
                                  ->filter(fn($e) => $e->resteAPayer() > 0);
        }

        
        return view('dashboard.gestionnaire', compact(
            'totalEleves', 'totalClasses', 'fraisAttendu',
            'fraisCollecte', 'tauxCollecte', 'elevesImpayes', 'classes',
            'parents', 'totalParents'
        ));
    }
}