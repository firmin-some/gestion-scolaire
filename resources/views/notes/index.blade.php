@extends('layouts.app')
@section('title', 'Saisie des notes')

@section('content')
<div class="card p-4 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-pencil-fill text-warning"></i> Saisir les notes</h6>

    <form method="GET" action="{{ route('notes.index') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Classe</label>
            <select name="classe_id" class="form-select" onchange="this.form.submit()">
                <option value="">— Choisir une classe —</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}"
                        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Trimestre</label>
            <select name="trimestre" class="form-select" onchange="this.form.submit()">
                @foreach(['T1' => '1er Trimestre','T2' => '2e Trimestre','T3' => '3e Trimestre'] as $k => $v)
                    <option value="{{ $k }}" {{ request('trimestre', 'T1') == $k ? 'selected' : '' }}>
                        {{ $v }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if(request('classe_id'))
    @php
        $elevesClasse = \App\Models\Eleve::where('classe_id', request('classe_id'))
            ->with(['notes' => fn($q) => $q->where('trimestre', request('trimestre','T1'))])
            ->get();
        $matieres = ['Français','Mathématiques','Sciences','Histoire-Géo','Anglais','EPS'];
        $trimestre = request('trimestre','T1');
    @endphp

    @php $isGestionnaire = auth()->user()->hasRole('Gestionnaire'); @endphp

    @if($isGestionnaire)
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th class="text-start"
                            style="background-color:#212529 !important; color:#ffffff !important;">
                            Élève
                        </th>
                        @foreach($matieres as $m)
                            <th style="background-color:#212529 !important; color:#ffffff !important; font-size:12px">
                                {{ $m }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($elevesClasse as $eleve)
                    <tr>
                        <td class="text-start fw-semibold">
                            {{ $eleve->prenom }} {{ $eleve->nom }}
                        </td>
                        @foreach($matieres as $m)
                        @php
                            $note = $eleve->notes->firstWhere('matiere', $m);
                        @endphp
                        <td>
                            <span class="d-block py-2">
                                {{ $note ? $note->note : '—' }}
                            </span>
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($matieres) + 1 }}" class="text-muted py-3">
                            Aucun élève dans cette classe.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <form action="{{ route('notes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="classe_id" value="{{ request('classe_id') }}">
            <input type="hidden" name="trimestre" value="{{ $trimestre }}">

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th class="text-start"
                                style="background-color:#212529 !important; color:#ffffff !important;">
                                Élève
                            </th>
                            @foreach($matieres as $m)
                                <th style="background-color:#212529 !important; color:#ffffff !important; font-size:12px">
                                    {{ $m }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($elevesClasse as $eleve)
                        <tr>
                            <td class="text-start fw-semibold">
                                {{ $eleve->prenom }} {{ $eleve->nom }}
                            </td>
                            @foreach($matieres as $m)
                            @php
                                $note = $eleve->notes->firstWhere('matiere', $m);
                            @endphp
                            <td>
                                <input type="number"
                                       name="notes[{{ $eleve->id }}][{{ $m }}]"
                                       value="{{ $note ? $note->note : '' }}"
                                       min="0" max="20" step="0.25"
                                       class="form-control form-control-sm text-center"
                                       style="width:65px;margin:auto"
                                       placeholder="—">
                            </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($matieres) + 1 }}" class="text-muted py-3">
                                Aucun élève dans cette classe.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($elevesClasse->isNotEmpty())
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Enregistrer toutes les notes
            </button>
            @endif
        </form>
    @endif
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Sélectionnez une classe pour afficher les élèves et saisir les notes.
        </div>
    @endif
</div>
@endsection