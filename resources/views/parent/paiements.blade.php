@extends('layouts.app')
@section('title', 'Paiements de '.$eleve->prenom)

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <h5 class="fw-bold mb-0">
        Paiements de {{ $eleve->prenom }} {{ $eleve->nom }}
        <span class="badge bg-primary ms-2">{{ $eleve->classe->nom ?? '—' }}</span>
    </h5>
    @if($eleve->resteAPayer() > 0)
        <a href="{{ route('parent.paiements.form', $eleve) }}" class="btn btn-success ms-auto">
            <i class="bi bi-cash-coin"></i> Payer maintenant
        </a>
    @endif
</div>

@php
    $frais = $eleve->classe->frais ?? 0;
    $paye  = $eleve->totalPaye();
    $reste = $eleve->resteAPayer();
    $taux  = $frais > 0 ? round($paye / $frais * 100) : 0;
@endphp

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card stat-card gold p-3">
            <div class="text-muted small">Frais annuels</div>
            <div class="fs-4 fw-bold">{{ number_format($frais,0,',',' ') }} F</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card green p-3">
            <div class="text-muted small">Total payé</div>
            <div class="fs-4 fw-bold text-success">{{ number_format($paye,0,',',' ') }} F</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card {{ $reste > 0 ? 'red' : 'green' }} p-3">
            <div class="text-muted small">Reste à payer</div>
            <div class="fs-4 fw-bold {{ $reste > 0 ? 'text-danger' : 'text-success' }}">
                {{ number_format($reste,0,',',' ') }} F
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white fw-bold">
        <i class="bi bi-clock-history"></i> Historique des versements
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Reçu</th> 
                </tr>
            </thead>
            <tbody>
                @forelse($eleve->paiements as $p)
                <tr>
                    <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
                    <td><strong>{{ number_format($p->montant,0,',',' ') }} F</strong></td>
                    <td>{{ $p->mode_paiement }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-3">
                        Aucun versement enregistré.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection