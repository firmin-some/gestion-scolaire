<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NoteController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('notes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'trimestre' => 'required|in:T1,T2,T3',
            'notes'     => 'required|array',
        ]);

        foreach ($request->notes as $eleveId => $matieres) {
            foreach ($matieres as $matiere => $note) {
                if ($note === null || $note === '') continue;
                Note::updateOrCreate(
                    [
                        'eleve_id'  => $eleveId,
                        'classe_id' => $request->classe_id,
                        'trimestre' => $request->trimestre,
                        'matiere'   => $matiere,
                    ],
                    ['note' => $note]
                );
            }
        }

        return redirect()->route('notes.index')
                         ->with('success', 'Notes enregistrées avec succès !');
    }

    public function getEleves(Request $request)
    {
        $eleves = Eleve::where('classe_id', $request->classe_id)
                       ->with(['notes' => function($q) use ($request) {
                           $q->where('trimestre', $request->trimestre);
                       }])
                       ->get();
        return response()->json($eleves);
    }

    public function moyennes(Request $request)
{
    $classes  = Classe::all();
    $matieres = ['Français','Mathématiques','Sciences','Histoire-Géo','Anglais','EPS'];
    $eleves   = collect();

    if ($request->filled('classe_id') && $request->filled('trimestre')) {
        $eleves = Eleve::where('classe_id', $request->classe_id)
                       ->with(['notes' => fn($q) =>
                           $q->where('trimestre', $request->trimestre)])
                       ->get();
    }

    return view('notes.moyennes', compact('classes','matieres','eleves'));
}

    public function classement(Request $request)
    {
        $classes = Classe::all();
        $eleves  = collect();

        if ($request->filled('classe_id') && $request->filled('trimestre')) {
            $eleves = Eleve::where('classe_id', $request->classe_id)
                           ->with(['notes' => fn($q) =>
                               $q->where('trimestre', $request->trimestre)])
                           ->get()
                           ->sortByDesc(fn($e) =>
                               $e->notes->avg('note') ?? 0)
                           ->values();
        }

        return view('notes.classement', compact('classes','eleves'));
    }
    public function bulletinPdf(Request $request)
{
    $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'trimestre' => 'required|in:T1,T2,T3',
    ]);

    $classe   = Classe::with('eleves.notes')->find($request->classe_id);
    $matieres = ['Français','Mathématiques','Sciences','Histoire-Géo','Anglais','EPS'];
    $trimestre= $request->trimestre;

    $eleves = Eleve::where('classe_id', $request->classe_id)
                   ->with(['notes' => fn($q) => $q->where('trimestre', $trimestre)])
                   ->get()
                   ->sortByDesc(fn($e) => $e->notes->avg('note') ?? 0)
                   ->values();

    $pdf = Pdf::loadView('pdf.bulletin', compact('classe','eleves','matieres','trimestre'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('bulletin-'.$classe->nom.'-'.$trimestre.'.pdf');
}
}