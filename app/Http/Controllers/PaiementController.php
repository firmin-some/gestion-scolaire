<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('eleve.classe')
                              ->latest()
                              ->get();
        $eleves = Eleve::with('classe')->get();
        return view('paiements.index', compact('paiements', 'eleves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'eleve_id'       => 'required|exists:eleves,id',
            'montant'        => 'required|integer|min:1',
            'date_paiement'  => 'required|date',
            'mode_paiement'  => 'required|string',
        ]);

        $paiement = Paiement::create($request->all());
        $eleve    = Eleve::with('classe', 'paiements')->find($request->eleve_id);

        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement enregistré !')
                         ->with('recu_eleve', $eleve)
                         ->with('recu_paiement', $paiement);
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        return redirect()->route('paiements.index')
                         ->with('success', 'Paiement supprimé.');
    }

    public function recuPdf(Paiement $paiement)
    {
        $paiement->load('eleve.classe', 'eleve.paiements');
        $eleve  = $paiement->eleve;
        $classe = $eleve->classe;

        $data = [
            'paiement' => $paiement,
            'eleve'    => $eleve,
            'classe'   => $classe,
            'totalPaye'=> $eleve->totalPaye(),
            'reste'    => $eleve->resteAPayer(),
        ];

        $pdf = Pdf::loadView('pdf.recu', $data)
                  ->setPaper('a5', 'portrait');

        return $pdf->download('recu-'.$eleve->nom.'-'.$paiement->id.'.pdf');
    }

    // ✅ Valider un paiement
    public function valider(Paiement $paiement)
    {
        $paiement->update(['statut' => 'validé']);
        return back()->with('success', 'Paiement validé !');
    }

    // ✅ Rejeter un paiement
    public function rejeter(Paiement $paiement)
    {
        $paiement->update(['statut' => 'rejeté']);
        return back()->with('success', 'Paiement rejeté.');
    }
}