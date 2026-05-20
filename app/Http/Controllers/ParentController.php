<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}