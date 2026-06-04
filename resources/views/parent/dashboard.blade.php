@extends('layouts.app')
@section('title', 'Mon Espace Parent')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-house-heart-fill text-warning"></i> Mon Espace Parent</h5>
    <a href="{{ route('parent.inscrire') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Inscrire un enfant
    </a>
</div>

@if($eleves->isEmpty())
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        Vous n'avez pas encore inscrit d'enfant.
        <a href="{{ route('parent.inscrire') }}" class="fw-bold">Inscrire maintenant</a>
    </div>
@else
    <div class="row g-3">
        @foreach($eleves as $eleve)
        <div class="col-md-6">
            <div class="card p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                         style="width:50px;height:50px;font-size:20px;
                                background:{{ $eleve->sexe=='F' ? '#e83e8c' : '#1a1a2e' }}">
                        {{ strtoupper(substr($eleve->prenom,0,1)) }}
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0">{{ $eleve->prenom }} {{ $eleve->nom }}</h6>
                        <span class="badge bg-primary">{{ $eleve->classe->nom ?? '—' }}</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('parent.notes', $eleve) }}"
                       class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="bi bi-book-fill"></i> Notes
                    </a>
                    <a href="{{ route('parent.paiements', $eleve) }}"
                       class="btn btn-outline-success btn-sm flex-fill">
                        <i class="bi bi-cash-coin"></i> Paiements
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection