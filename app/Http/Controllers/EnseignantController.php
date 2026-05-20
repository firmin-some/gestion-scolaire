<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
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
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'sexe'      => 'required|in:M,F',
            'email'     => 'nullable|email|max:100',
            'telephone' => 'nullable|string|max:20',
            'specialite'=> 'nullable|string|max:100',
            'date_naissance' => 'nullable|date',
        ]);

        Enseignant::create($request->all());
        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant ajouté avec succès !');
    }

    public function edit(Enseignant $enseignant)
    {
        return view('enseignants.edit', compact('enseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom'       => 'required|string|max:100',
            'prenom'    => 'required|string|max:100',
            'sexe'      => 'required|in:M,F',
            'email'     => 'nullable|email|max:100',
            'telephone' => 'nullable|string|max:20',
            'specialite'=> 'nullable|string|max:100',
            'date_naissance' => 'nullable|date',
        ]);

        $enseignant->update($request->all());
        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant modifié avec succès !');
    }

    public function destroy(Enseignant $enseignant)
    {
        $enseignant->delete();
        return redirect()->route('enseignants.index')
                         ->with('success', 'Enseignant supprimé.');
    }
}