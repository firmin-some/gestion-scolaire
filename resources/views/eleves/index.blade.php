@extends('layouts.app')
@section('title', 'Élèves')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-people-fill"></i> Liste des élèves</h5>
    @if(auth()->user()->role === 'gestionnaire')
    <a href="{{ route('eleves.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Inscrire un élève
    </a>
    @endif
</div>

{{-- Filtres --}}
<div class="card p-3 mb-3">
    <form method="GET" action="{{ route('eleves.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Rechercher</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control form-control-sm" placeholder="Nom ou prénom...">
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold">Filtrer par classe</label>
            <select name="classe_id" class="form-select form-select-sm">
                <option value="">Toutes les classes</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}"
                        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="bi bi-search"></i> Filtrer
            </button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                <i class="bi bi-x-circle"></i> Réinitialiser
            </a>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Élève</th>
                    <th>Classe</th>
                    <th>Parent / Téléphone</th>
                    <th>Statut paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($eleves as $eleve)
                @php
                    $reste = $eleve->resteAPayer();
                    $paye  = $eleve->totalPaye();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($eleve->photo)
                                <img src="{{ asset('storage/'.$eleve->photo) }}"
                                     class="rounded-circle" width="36" height="36"
                                     style="object-fit:cover">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center
                                            justify-content-center text-white fw-bold"
                                     style="width:36px;height:36px;font-size:14px">
                                    {{ strtoupper(substr($eleve->prenom,0,1)) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $eleve->prenom }} {{ $eleve->nom }}</strong>
                                <div class="text-muted small">
                                    {{ $eleve->sexe == 'M' ? '👦' : '👧' }}
                                    {{ $eleve->date_naissance ? \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') : '—' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $eleve->classe->nom ?? '—' }}</td>
                    <td>
                        {{ $eleve->nom_parent }}<br>
                        <small class="text-muted">{{ $eleve->telephone_parent ?? '—' }}</small>
                    </td>
                    <td>
                        @if($reste == 0)
                            <span class="badge badge-solde px-2 py-1">✅ Soldé</span>
                        @elseif($paye > 0)
                            <span class="badge badge-partiel px-2 py-1">
                                ⚠️ Partiel ({{ number_format($reste,0,',',' ') }} F restant)
                            </span>
                        @else
                            <span class="badge badge-nonpaye px-2 py-1">❌ Non payé</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('eleves.show', $eleve->id) }}"
                           class="btn btn-sm btn-outline-info" title="Voir">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if(auth()->user()->role === 'gestionnaire')
                        <a href="{{ route('eleves.edit', $eleve->id) }}"
                           class="btn btn-sm btn-outline-warning" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('eleves.destroy', $eleve->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cet élève ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Aucun élève trouvé.
                        @if(auth()->user()->role === 'gestionnaire')
                        <a href="{{ route('eleves.create') }}">Inscrire un élève</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection