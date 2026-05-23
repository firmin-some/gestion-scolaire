<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = Enseignant::all();
        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        return view('enseignants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'            => 'required|string|max:100',
            'prenom'         => 'required|string|max:100',
            'sexe'           => 'required|in:M,F',
            'email'          => 'required|email|unique:users,email|unique:enseignants,email',
            'telephone'      => 'nullable|string|max:20',
            'specialite'     => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'code'           => 'required|string|unique:enseignants,code',
        ]);

        // Créer le compte User pour la connexion
        $user = User::create([
            'name'     => $request->nom . ' ' . $request->prenom,
            'email'    => $request->email,
            'password' => bcrypt($request->code),
            'role'     => 'enseignant',
        ]);

        // Créer le profil enseignant
        Enseignant::create([
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'sexe'           => $request->sexe,
            'email'          => $request->email,
            'telephone'      => $request->telephone,
            'specialite'     => $request->specialite,
            'date_naissance' => $request->date_naissance,
            'code'           => $request->code,
            'user_id'        => $user->id,
        ]);

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant inscrit avec succès. Code de connexion : ' . $request->code);
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
        // Supprimer aussi le User lié
        if ($enseignant->user_id) {
            User::find($enseignant->user_id)?->delete();
        }

        $enseignant->delete();

        return redirect()->route('enseignants.index')
            ->with('success', 'Enseignant supprimé.');
    }
}