@extends('layouts.app')
@section('title', 'Notes de '.$eleve->prenom)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <h5 class="fw-bold mb-0">
        Notes de {{ $eleve->prenom }} {{ $eleve->nom }}
        <span class="badge bg-primary ms-2">{{ $eleve->classe->nom ?? '—' }}</span>
    </h5>
</div>

<div class="d-flex justify-content-end gap-2 mb-4">
    @foreach(['T1'=>'1er Trimestre','T2'=>'2e Trimestre','T3'=>'3e Trimestre'] as $trim => $label)
        <a href="{{ route('parent.bulletin.pdf', ['eleve' => $eleve, 'trimestre' => $trim]) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> {{ $label }}
        </a>
    @endforeach
</div>

@foreach(['T1'=>'1er Trimestre','T2'=>'2e Trimestre','T3'=>'3e Trimestre'] as $trim => $label)
@php
    $notesTrim = $eleve->notes->where('trimestre', $trim);
    $moy = $notesTrim->isNotEmpty() ? round($notesTrim->avg('note'), 2) : null;
    $mention = $moy === null ? '—' :
        ($moy >= 16 ? 'Excellent' : ($moy >= 14 ? 'Bien' :
        ($moy >= 12 ? 'Assez bien' : ($moy >= 10 ? 'Passable' : 'Insuffisant'))));
@endphp
<div class="card p-4 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0"><i class="bi bi-calendar3"></i> {{ $label }}</h6>
        @if($moy)
            <span class="badge bg-{{ $moy >= 14 ? 'success' : ($moy >= 10 ? 'warning text-dark' : 'danger') }} fs-6">
                Moyenne : {{ $moy }}/20 — {{ $mention }}
            </span>
        @endif
    </div>

    @if($notesTrim->isEmpty())
        <p class="text-muted small">Aucune note saisie pour ce trimestre.</p>
    @else
        <div class="row g-2">
            @foreach($matieres as $m)
            @php $n = $notesTrim->firstWhere('matiere', $m); @endphp
            <div class="col-md-4 col-6">
                <div class="border rounded p-2 text-center">
                    <div class="text-muted small">{{ $m }}</div>
                    <div class="fs-4 fw-bold {{ $n ? ($n->note >= 10 ? 'text-success' : 'text-danger') : 'text-muted' }}">
                        {{ $n ? $n->note : '—' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endforeach
@endsection