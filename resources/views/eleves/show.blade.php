@extends('layouts.app')
@section('title', 'Fiche élève')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card p-4 text-center">
            @if($eleve->photo)
                <img src="{{ asset('storage/'.$eleve->photo) }}"
                     class="rounded-circle mx-auto mb-3"
                     width="100" height="100" style="object-fit:cover">
            @else
                <div class="rounded-circle bg-secondary d-flex align-items-center
                            justify-content-center text-white fw-bold mx-auto mb-3"
                     style="width:100px;height:100px;font-size:36px">
                    {{ strtoupper(substr($eleve->prenom,0,1)) }}
                </div>
            @endif
            <h5 class="fw-bold">{{ $eleve->prenom }} {{ $eleve->nom }}</h5>
            <span class="badge bg-primary">{{ $eleve->classe->nom ?? '—' }}</span>
            <hr>
            <div class="text-start small">
                <p><strong>Sexe :</strong> {{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</p>
                <p><strong>Naissance :</strong>
                    {{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '—' }}
                </p>
                <p><strong>Parent :</strong> {{ $eleve->nom_parent }}</p>
                <p><strong>Tél :</strong> {{ $eleve->telephone_parent ?? '—' }}</p>
            </div>
      @if(auth()->user()->hasRole('Gestionnaire'))
      <a href="{{ route('eleves.edit', $eleve->id) }}" class="btn btn-outline-warning btn-sm mt-2">
                <i class="bi bi-pencil"></i> Modifier
      </a>
      @endif
        </div>
    </div>

    <div class="col-md-8">
        {{-- Situation financière --}}
        <div class="card p-4 mb-3">
            <h6 class="fw-bold mb-3"><i class="bi bi-cash-coin text-warning"></i> Situation financière</h6>
            @php
                $frais  = $eleve->classe->frais ?? 0;
                $paye   = $eleve->totalPaye();
                $reste  = $eleve->resteAPayer();
                $taux   = $frais > 0 ? round($paye / $frais * 100) : 0;
            @endphp
            <div class="row text-center mb-3">
                <div class="col">
                    <div class="text-muted small">Frais annuels</div>
                    <div class="fs-5 fw-bold">{{ number_format($frais,0,',',' ') }} F</div>
                </div>
                <div class="col">
                    <div class="text-muted small">Total payé</div>
                    <div class="fs-5 fw-bold text-success">{{ number_format($paye,0,',',' ') }} F</div>
                </div>
                <div class="col">
                    <div class="text-muted small">Reste à payer</div>
                    <div class="fs-5 fw-bold {{ $reste > 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($reste,0,',',' ') }} F
                    </div>
                </div>
            </div>
            <div class="progress mb-2" style="height:10px">
                <div class="progress-bar bg-success" style="width:{{ $taux }}%"></div>
            </div>
            <small class="text-muted">{{ $taux }}% payé</small>
        </div>

        {{-- Historique paiements --}}
        <div class="card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history text-info"></i> Historique des paiements</h6>
            @if($eleve->paiements->isEmpty())
                <p class="text-muted">Aucun paiement enregistré.</p>
            @else
                <table class="table table-sm">
                    <thead>
                        <tr><th>Date</th><th>Montant</th><th>Mode</th></tr>
                    </thead>
                    <tbody>
                        @foreach($eleve->paiements as $p)
                        <tr>
                            <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
                            <td><strong>{{ number_format($p->montant,0,',',' ') }} F</strong></td>
                            <td>{{ $p->mode_paiement }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection