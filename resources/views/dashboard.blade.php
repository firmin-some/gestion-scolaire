@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')

{{-- STATS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card gold p-3">
            <div class="text-muted small">Élèves inscrits</div>
            <div class="fs-2 fw-bold">{{ $totalEleves }}</div>
            <div class="text-muted small">{{ $totalClasses }} classes</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card green p-3">
            <div class="text-muted small">Frais collectés</div>
            <div class="fs-2 fw-bold text-success">{{ number_format($fraisCollecte, 0, ',', ' ') }} F</div>
            <div class="text-muted small">{{ $tauxCollecte }}% du total attendu</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card red p-3">
            <div class="text-muted small">Frais attendus</div>
            <div class="fs-2 fw-bold text-danger">{{ number_format($fraisAttendu, 0, ',', ' ') }} F</div>
            <div class="text-muted small">Total annuel</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card blue p-3">
            <div class="text-muted small">Élèves impayés</div>
            <div class="fs-2 fw-bold text-primary">{{ $elevesImpayes->count() }}</div>
            <div class="text-muted small">avec reste à payer</div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Frais par classe --}}
    <div class="col-md-7">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill text-warning"></i> Frais par classe</h6>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>Classe</th>
                        <th>Attendu</th>
                        <th>Collecté</th>
                        <th>Taux</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $classe)
                    @php
                        $attendu  = $classe->eleves->count() * $classe->frais;
                        $collecte = $classe->eleves->sum(fn($e) => $e->paiements->sum('montant'));
                        $taux     = $attendu > 0 ? round($collecte / $attendu * 100) : 0;
                    @endphp
                    <tr>
                        <td><strong>{{ $classe->nom }}</strong></td>
                        <td>{{ number_format($attendu, 0, ',', ' ') }} F</td>
                        <td>{{ number_format($collecte, 0, ',', ' ') }} F</td>
                        <td>
                            <div class="progress" style="height:8px;width:100px">
                                <div class="progress-bar {{ $taux >= 80 ? 'bg-success' : ($taux >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                     style="width:{{ $taux }}%"></div>
                            </div>
                            <small>{{ $taux }}%</small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Élèves impayés --}}
    <div class="col-md-5">
        <div class="card p-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-exclamation-triangle-fill text-danger"></i> Élèves impayés</h6>
            @if($elevesImpayes->isEmpty())
                <div class="text-center text-success py-3">
                    <i class="bi bi-check-circle-fill fs-3"></i>
                    <p class="mt-2">Aucun impayé !</p>
                </div>
            @else
                <table class="table table-sm table-hover">
                    <thead>
                        <tr><th>Élève</th><th>Classe</th><th>Reste</th></tr>
                    </thead>
                    <tbody>
                        @foreach($elevesImpayes->take(8) as $eleve)
                        <tr>
                            <td>{{ $eleve->prenom }} {{ $eleve->nom }}</td>
                            <td>{{ $eleve->classe->nom ?? '—' }}</td>
                            <td>
                                <span class="badge badge-nonpaye">
                                    {{ number_format($eleve->resteAPayer(), 0, ',', ' ') }} F
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@endsection