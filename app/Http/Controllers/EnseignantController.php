<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::with('classe')->get();

        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        $classes = Classe::orderBy('niveau')->orderBy('nom')->get();
        $subjects = $this->subjects();

        return view('enseignants.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'sexe'           => 'required|in:M,F',
            'email'          => 'required|email|unique:users,email|unique:enseignants,email',
            'telephone'      => 'nullable|string|max:20',
            'specialite'     => ['required', 'string', 'max:100', Rule::in(array_keys($this->subjects()))],
            'date_naissance' => 'required|date',
            'code'           => 'required|string|unique:enseignants,code',
            'classe_id'      => 'required|exists:classes,id',
        ]);

        $classe = Classe::findOrFail($request->classe_id);
        $statut = empty(trim($classe->enseignant)) ? 'titulaire' : 'secondaire';

        // Création du compte User pour la connexion
        $user = User::create([
            'name'     => $request->nom . ' ' . $request->prenom,
            'email'    => $request->email,
            'password' => $request->code, // Le casting 'hashed' du modèle User va le hasher automatiquement
            'role'     => 'enseignant',
        ]);

        $enseignant = Enseignant::create([
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'sexe'           => $request->sexe,
            'email'          => $request->email,
            'telephone'      => $request->telephone,
            'specialite'     => $request->specialite,
            'date_naissance' => $request->date_naissance,
            'code'           => $request->code,
            'user_id'        => $user->id,
            'classe_id'      => $classe->id,
            'statut'         => $statut,
        ]);

        if ($statut === 'titulaire') {
            $classe->enseignant = $enseignant->prenom . ' ' . $enseignant->nom;
            $classe->save();
        }

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant inscrit avec succès. Code de connexion : ' . $request->code . ' (' . ucfirst($statut) . ' de la classe ' . $classe->nom . ')');
    }

    public function edit(Enseignant $enseignant)
    {
        return view('enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'sexe'           => 'required|in:M,F',
            'email'          => 'nullable|email|max:100',
            'telephone'      => 'nullable|string|max:20',
            'specialite'     => 'nullable|string|max:100',
            'date_naissance' => 'nullable|date',
        ]);

        $enseignant->update($request->only([
            'nom', 'prenom', 'sexe', 'email',
            'telephone', 'specialite', 'date_naissance'
        ]));

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant modifié avec succès !');
    }

    public function destroy(Enseignant $enseignant)
    {
        if ($enseignant->user_id) {
            User::find($enseignant->user_id)?->delete();
        }

        $enseignant->delete();

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant supprimé.');
    }

    private function subjects(): array
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
}
