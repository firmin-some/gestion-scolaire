<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $query = Eleve::with('classe', 'paiements');

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%'.$request->search.'%')
                  ->orWhere('prenom', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        $eleves  = $query->get();
        $classes = Classe::all();
        return view('eleves.index', compact('eleves', 'classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('eleves.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'               => 'required|string|max:100',
            'prenom'            => 'required|string|max:100',
            'sexe'              => 'required|in:M,F',
            'classe_id'         => 'required|exists:classes,id',
            'nom_parent'        => 'required|string|max:100',
            'date_naissance'    => 'nullable|date',
            'telephone_parent'  => 'nullable|string|max:20',
            'photo'             => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                                     ->store('photos', 'public');
        }

        Eleve::create($data);
        return redirect()->route('eleves.index')
                         ->with('success', 'Élève inscrit avec succès !');
    }

    public function show(Eleve $eleve)
    {
        $eleve->load('classe', 'paiements', 'notes');
        return view('eleves.show', compact('eleve'));
    }

    public function edit(Eleve $eleve)
    {
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    public function update(Request $request, Eleve $eleve)
    {
        $request->validate([
            'nom'              => 'required|string|max:100',
            'prenom'           => 'required|string|max:100',
            'sexe'             => 'required|in:M,F',
            'classe_id'        => 'required|exists:classes,id',
            'nom_parent'       => 'required|string|max:100',
            'date_naissance'   => 'nullable|date',
            'telephone_parent' => 'nullable|string|max:20',
            'photo'            => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                                     ->store('photos', 'public');
        }

        $eleve->update($data);
        return redirect()->route('eleves.index')
                         ->with('success', 'Élève modifié avec succès !');
    }

    public function destroy(Eleve $eleve)
    {
        $eleve->delete();
        return redirect()->route('eleves.index')
                         ->with('success', 'Élève supprimé.');
    }
}