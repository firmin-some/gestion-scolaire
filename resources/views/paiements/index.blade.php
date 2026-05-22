@extends('layouts.app')
@section('title', 'Paiements')

@section('content')
<div class="row g-4">

    {{-- Formulaire paiement --}}
    <div class="col-md-5">
        <div class="card p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-cash-coin text-warning"></i> Enregistrer un versement</h6>

            <form action="{{ route('paiements.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Élève</label>
                    <select name="eleve_id" id="eleve_id" class="form-select @error('eleve_id') is-invalid @enderror"
                            onchange="afficherSolde(this)">
                        <option value="">— Choisir un élève —</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->id }}"
                                    data-frais="{{ $eleve->classe->frais ?? 0 }}"
                                    data-paye="{{ $eleve->totalPaye() }}"
                                    data-reste="{{ $eleve->resteAPayer() }}"
                                    data-classe="{{ $eleve->classe->nom ?? '' }}"
                                    {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                {{ $eleve->prenom }} {{ $eleve->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('eleve_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Info solde --}}
                <div id="info-solde" class="alert alert-info py-2 small d-none">
                    <div id="solde-text"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Montant versé (FCFA)</label>
                    <input type="number" name="montant" id="montant"
                           value="{{ old('montant') }}"
                           class="form-control @error('montant') is-invalid @enderror"
                           placeholder="Ex: 15000" min="1">
                    @error('montant')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Date du versement</label>
                    <input type="date" name="date_paiement"
                           value="{{ old('date_paiement', date('Y-m-d')) }}"
                           class="form-control @error('date_paiement') is-invalid @enderror">
                    @error('date_paiement')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Mode de paiement</label>
                    <select name="mode_paiement" class="form-select">
                        @foreach(['Espèces','Mobile Money','Virement','Chèque'] as $mode)
                            <option {{ old('mode_paiement') == $mode ? 'selected' : '' }}>
                                {{ $mode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-circle"></i> Enregistrer le paiement
                </button>
            </form>
        </div>

        {{-- Reçu --}}
        @if(session('recu_eleve') && session('recu_paiement'))
        @php
            $re = session('recu_eleve');
            $rp = session('recu_paiement');
        @endphp
        <div class="card p-4 mt-3 border-success" id="recu-section">
            <div class="text-center mb-3">
                <h6 class="fw-bold">🏫 EcolePrime</h6>
                <div class="fw-bold text-uppercase small letter-spacing-1">Reçu de Paiement</div>
                <div class="text-muted small">N° {{ strtoupper($rp->id) }}</div>
            </div>
            <hr>
            <div class="small">
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Élève</span>
                    <strong>{{ $re->prenom }} {{ $re->nom }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Classe</span>
                    <strong>{{ $re->classe->nom ?? '—' }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Date</span>
                    <strong>{{ $rp->date_paiement->format('d/m/Y') }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Mode</span>
                    <strong>{{ $rp->mode_paiement }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                    <span class="text-muted">Frais annuels</span>
                    <strong>{{ number_format($re->classe->frais ?? 0, 0, ',', ' ') }} F</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-1 fs-6">
                    <span class="fw-bold">Montant versé</span>
                    <strong class="text-success">{{ number_format($rp->montant, 0, ',', ' ') }} F</strong>
                </div>
                <div class="d-flex justify-content-between mb-1 fs-6">
                    <span class="fw-bold">Reste à payer</span>
                    <strong class="{{ $re->resteAPayer() > 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($re->resteAPayer(), 0, ',', ' ') }} F
                    </strong>
                </div>
            </div>
            <div class="text-center mt-3 p-2 rounded {{ $re->resteAPayer() == 0 ? 'bg-success' : 'bg-warning' }} bg-opacity-10">
                <strong>{{ $re->resteAPayer() == 0 ? '✅ COMPTE SOLDÉ' : '⚠️ Solde restant à régler' }}</strong>
            </div>
            <div class="d-flex gap-2 mt-3">
                <button class="btn btn-outline-secondary btn-sm w-50" onclick="window.print()">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
                <a href="{{ route('paiements.recu-pdf', $rp) }}"
                   class="btn btn-success btn-sm w-50">
                    <i class="bi bi-file-pdf"></i> PDF
                </a>
            </div>
        </div>
        @endif
    </div>

    {{-- Historique --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-white fw-bold">
                <i class="bi bi-clock-history"></i> Historique des paiements
                <span class="badge bg-secondary">{{ $paiements->count() }}</span>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Montant</th>
                            <th>Mode</th>
                            <th>Reste</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $p)
                        <tr>
                            <td>{{ $p->date_paiement->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $p->eleve->prenom }} {{ $p->eleve->nom }}</strong>
                            </td>
                            <td>{{ $p->eleve->classe->nom ?? '—' }}</td>
                            <td><strong>{{ number_format($p->montant,0,',',' ') }} F</strong></td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $p->mode_paiement }}</span>
                            </td>
                            <td>
                                @php $reste = $p->eleve->resteAPayer(); @endphp
                                <span class="badge {{ $reste == 0 ? 'badge-solde' : 'badge-nonpaye' }} px-2">
                                    {{ number_format($reste,0,',',' ') }} F
                                </span>
                            </td>
                            <td class="d-flex gap-1">
<td>
    @if($p->statut === 'validé')
        <span class="badge bg-success">✅ Validé</span>
    @elseif($p->statut === 'rejeté')
        <span class="badge bg-danger">❌ Rejeté</span>
    @else
        <span class="badge bg-warning text-dark">⏳ En attente</span>
    @endif
</td>

{{-- Actions --}}
<td class="d-flex gap-1 flex-wrap">

    {{-- Valider --}}
    @if($p->statut === 'en_attente')
    <form action="{{ route('paiements.valider', $p) }}" method="POST">
        @csrf @method('PATCH')
        <button class="btn btn-sm btn-success" title="Valider">
            <i class="bi bi-check-lg"></i>
        </button>
    </form>

    {{-- Rejeter --}}
    <form action="{{ route('paiements.rejeter', $p) }}" method="POST">
        @csrf @method('PATCH')
        <button class="btn btn-sm btn-danger" title="Rejeter">
            <i class="bi bi-x-lg"></i>
        </button>
    </form>
    @endif

    {{-- PDF uniquement si validé --}}
    @if($p->statut === 'validé')
    <a href="{{ route('paiements.recu-pdf', $p) }}"
       class="btn btn-sm btn-outline-success"
       title="Télécharger reçu PDF">
        <i class="bi bi-file-pdf"></i>
    </a>
    @endif

    {{-- Supprimer --}}
    <form action="{{ route('paiements.destroy', $p) }}"
          method="POST"
          onsubmit="return confirm('Supprimer ce paiement ?')">
        @csrf @method('DELETE')
        <button class="btn btn-sm btn-outline-danger">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucun paiement enregistré.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function afficherSolde(select) {
    const opt    = select.options[select.selectedIndex];
    const frais  = parseInt(opt.dataset.frais) || 0;
    const paye   = parseInt(opt.dataset.paye)  || 0;
    const reste  = parseInt(opt.dataset.reste) || 0;
    const classe = opt.dataset.classe || '';

    if (!opt.value) {
        document.getElementById('info-solde').classList.add('d-none');
        return;
    }

    document.getElementById('solde-text').innerHTML =
        `<strong>${opt.text}</strong> — ${classe}<br>
         Frais: <strong>${frais.toLocaleString()} F</strong> |
         Payé: <strong class="text-success">${paye.toLocaleString()} F</strong> |
         Reste: <strong class="text-danger">${reste.toLocaleString()} F</strong>`;

    document.getElementById('info-solde').classList.remove('d-none');
    document.getElementById('montant').value = reste > 0 ? reste : '';
}
</script>
@endsection