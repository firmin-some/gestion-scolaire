<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ParentController extends Controller
{
    // Dashboard parent
    public function dashboard()
    {
        $eleves = Eleve::where('parent_id', Auth::id())
                       ->with('classe', 'paiements', 'notes')
                       ->get();
        return view('parent.dashboard', compact('eleves'));
    }

    // Formulaire inscription enfant
    public function createEleve()
    {
        $classes = Classe::all();
        return view('parent.inscrire', compact('classes'));
    }

    // Enregistrer l'enfant
    public function storeEleve(Request $request)
    {
        $request->validate([
            'nom'              => 'required|string|max:100',
            'prenom'           => 'required|string|max:100',
            'sexe'             => 'required|in:M,F',
            'classe_id'        => 'required|exists:classes,id',
            'date_naissance'   => 'nullable|date',
            'telephone_parent' => 'nullable|string|max:20',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');
        $data['parent_id']  = Auth::id();
        $data['nom_parent'] = Auth::user()->name;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                                     ->store('photos', 'public');
        }

        Eleve::create($data);

        return redirect()->route('parent.dashboard')
                         ->with('success', 'Votre enfant a été inscrit avec succès !');
    }

    // Voir les notes d'un enfant
    public function notes(Eleve $eleve)
    {
        // Vérifier que l'élève appartient au parent connecté
        if ($eleve->parent_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $matieres = ['Français','Mathématiques','Sciences','Histoire-Géo','Anglais','EPS'];
        $eleve->load('notes', 'classe');
        return view('parent.notes', compact('eleve', 'matieres'));
    }

    // Voir les paiements d'un enfant
    public function paiements(Eleve $eleve)
    {
        if ($eleve->parent_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }

        $eleve->load('paiements', 'classe');
        return view('parent.paiements', compact('eleve'));
    }
    // Formulaire de paiement
public function formPaiement(Eleve $eleve)
{
    if ($eleve->parent_id !== Auth::id()) {
        abort(403, 'Accès non autorisé.');
    }
    $eleve->load('classe', 'paiements');
    return view('parent.payer', compact('eleve'));
}

// Enregistrer le paiement
public function storePaiement(Request $request, Eleve $eleve)
{
    if ($eleve->parent_id !== Auth::id()) {
        abort(403, 'Accès non autorisé.');
    }

    $request->validate([
        'montant'       => 'required|numeric|min:100',
        'mode_paiement' => 'required|in:Espèces,Orange Money,Moov Money,Virement',
    ]);

    $reste = $eleve->resteAPayer();

    if ($request->montant > $reste) {
        return back()->withErrors(['montant' => 'Le montant dépasse le reste à payer ('.$reste.' F)']);
    }

    $paiement = Paiement::create([
        'eleve_id'      => $eleve->id,
        'montant'       => $request->montant,
        'mode_paiement' => $request->mode_paiement,
        'date_paiement' => Carbon::today(),
    ]);

    return redirect()->route('parent.paiements.recu', $paiement->id)
                     ->with('success', 'Paiement enregistré !');
}

// Générer le reçu PDF
public function recuPdf(Paiement $paiement)
{
    if ($paiement->eleve->parent_id !== Auth::id()) {
        abort(403, 'Accès non autorisé.');
    }

    $paiement->load('eleve.classe');
    $pdf = Pdf::loadView('parent.recu-pdf', compact('paiement'))
              ->setPaper([0, 0, 226.77, 425.20]); // format ticket

    return $pdf->download('recu_'.$paiement->id.'.pdf');
}
}