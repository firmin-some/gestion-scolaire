@extends('layouts.app')
@section('title', 'Moyennes trimestrielles')

@section('content')
<style>
.thead-custom th {
    background-color: #1a1a2e !important;
    color: #ffffff !important;
    font-size: 12px !important;
    padding: 10px !important;
}
.thead-custom th.gold { color: #f0c040 !important; }
</style>

<div class="card p-4 mb-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill text-warning"></i> Moyennes trimestrielles</h6>

    <form method="GET" action="{{ route('notes.moyennes') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Classe</label>
            <select name="classe_id" class="form-select">
                <option value="">— Choisir —</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ request('classe_id')==$classe->id?'selected':'' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Trimestre</label>
            <select name="trimestre" class="form-select">
                <option value="T1" {{ request('trimestre','T1')=='T1'?'selected':'' }}>1er Trimestre</option>
                <option value="T2" {{ request('trimestre','T1')=='T2'?'selected':'' }}>2e Trimestre</option>
                <option value="T3" {{ request('trimestre','T1')=='T3'?'selected':'' }}>3e Trimestre</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Afficher
            </button>
        </div>
    </form>

    @if($eleves->isNotEmpty())
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('notes.bulletin-pdf', ['classe_id'=>request('classe_id'),'trimestre'=>request('trimestre','T1')]) }}"
           class="btn btn-danger btn-sm">
            <i class="bi bi-file-pdf"></i> Télécharger le bulletin PDF
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="thead-custom">
                <tr>
                    <th class="text-start gold">Élève</th>
                    <th>Français</th>
                    <th>Mathématiques</th>
                    <th>Sciences</th>
                    <th>Histoire-Géo</th>
                    <th>Anglais</th>
                    <th>EPS</th>
                    <th class="gold">Moyenne</th>
                    <th class="gold">Mention</th>
                </tr>
            </thead>
            <tbody>
                @php $matieres = ['Français','Mathématiques','Sciences','Histoire-Géo','Anglais','EPS']; @endphp
                @foreach($eleves as $eleve)
                @php
                    $notesList = [];
                    foreach($matieres as $m) {
                        $n = $eleve->notes->firstWhere('matiere', $m);
                        $notesList[$m] = $n ? $n->note : null;
                    }
                    $valides = array_filter($notesList, fn($v) => $v !== null);
                    $moy = count($valides) ? round(array_sum($valides)/count($valides),2) : null;
                    $mention = $moy===null ? '—' : ($moy>=16 ? 'Excellent' : ($moy>=14 ? 'Bien' : ($moy>=12 ? 'Assez bien' : ($moy>=10 ? 'Passable' : 'Insuffisant'))));
                    $mc = $moy===null ? 'secondary' : ($moy>=14 ? 'success' : ($moy>=10 ? 'warning text-dark' : 'danger'));
                @endphp
                <tr>
                    <td class="text-start fw-semibold">{{ $eleve->prenom }} {{ $eleve->nom }}</td>
                    @foreach($matieres as $m)
                        <td>{{ $notesList[$m] ?? '—' }}</td>
                    @endforeach
                    <td><strong class="{{ $moy ? ($moy>=10 ? 'text-success' : 'text-danger') : '' }}">{{ $moy ?? '—' }}</strong></td>
                    <td><span class="badge bg-{{ $mc }}">{{ $mention }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @elseif(request('classe_id'))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Aucune note saisie pour cette sélection.
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Sélectionnez une classe et un trimestre.
        </div>
    @endif
</div>
@endsection