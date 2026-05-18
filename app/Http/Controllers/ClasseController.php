<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('eleves')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string|max:100',
            'niveau'      => 'required|string',
            'enseignant'  => 'required|string|max:100',
            'frais'       => 'required|integer|min:0',
        ]);

        Classe::create($request->all());
        return redirect()->route('classes.index')
                         ->with('success', 'Classe créée avec succès !');
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom'        => 'required|string|max:100',
            'niveau'     => 'required|string',
            'enseignant' => 'required|string|max:100',
            'frais'      => 'required|integer|min:0',
        ]);

        $classe->update($request->all());
        return redirect()->route('classes.index')
                         ->with('success', 'Classe modifiée avec succès !');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')
                         ->with('success', 'Classe supprimée.');
    }
}