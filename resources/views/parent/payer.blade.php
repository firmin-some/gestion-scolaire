@extends('layouts.app')
@section('title', 'Payer la scolarité')

@section('content')
@php
    $reste = $eleve->resteAPayer();
    $frais = $eleve->classe->frais ?? 0;
    $paye  = $eleve->totalPaye();
@endphp

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('parent.paiements', $eleve) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <h5 class="fw-bold mb-0">Payer la scolarité de {{ $eleve->prenom }} {{ $eleve->nom }}</h5>
</div>

{{-- Résumé --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card p-3 border-warning">
            <div class="text-muted small">Frais annuels</div>
            <div class="fs-5 fw-bold">{{ number_format($frais,0,',',' ') }} F</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 border-success">
            <div class="text-muted small">Déjà payé</div>
            <div class="fs-5 fw-bold text-success">{{ number_format($paye,0,',',' ') }} F</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 border-danger">
            <div class="text-muted small">Reste à payer</div>
            <div class="fs-5 fw-bold text-danger">{{ number_format($reste,0,',',' ') }} F</div>
        </div>
    </div>
</div>

@if($reste <= 0)
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i> La scolarité de {{ $eleve->prenom }} est entièrement payée !
    </div>
@else
    <div class="card">
        <div class="card-header fw-bold bg-white">
            <i class="bi bi-cash-coin"></i> Effectuer un versement
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('parent.paiements.store', $eleve) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Montant à payer (F CFA)</label>
                    <input type="number" name="montant" class="form-control form-control-lg"
                           min="100" max="{{ $reste }}" value="{{ $reste }}" required>
                    <div class="form-text">Maximum : {{ number_format($reste,0,',',' ') }} F</div>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold">Mode de paiement</label>
                  <select name="mode_paiement" class="form-select" required>
    <option value="">-- Choisir --</option>
    <option value="Orange Money">🟠 Orange Money</option>
    <option value="Moov Money">🔵 Moov Money</option>
    <option value="Virement">🏦 Virement bancaire</option>
</select>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-check-lg"></i> Confirmer le paiement
                </button>
            </form>
        </div>
    </div>
@endif
@endsection