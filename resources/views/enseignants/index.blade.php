@extends('layouts.app')
@section('title', 'Enseignants')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-person-badge-fill"></i> Liste des enseignants</h5>
    <a href="{{ route('enseignants.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Ajouter un enseignant
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom & Prénom</th>
                    <th>Sexe</th>
                    <th>Spécialité</th>
                    <th>Classe</th>
                    <th>Statut</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th><i class="bi bi-key"></i> Code</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enseignants as $e)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                 style="width:36px;height:36px;font-size:14px;background:{{ $e->sexe=='F' ? '#e83e8c' : '#1a1a2e' }}">
                                {{ strtoupper(substr($e->prenom,0,1)) }}
                            </div>
                            <div>
                                <strong>{{ $e->prenom }} {{ $e->nom }}</strong>
                                <div class="text-muted small">
                                    {{ $e->sexe == 'M' ? '👨‍🏫 M.' : '👩‍🏫 Mme' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $e->sexe == 'M' ? 'Masculin' : 'Féminin' }}</td>
                    <td>
                        @if($e->specialite)
                            <span class="badge bg-primary">{{ $e->specialite_label }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $e->classe?->nom ?? '—' }}</td>
                    <td>
                        @if($e->statut === 'titulaire')
                            <span class="badge bg-success">Titulaire</span>
                        @elseif($e->statut === 'secondaire')
                            <span class="badge bg-secondary">Secondaire</span>
                        @else
                            <span class="badge bg-light text-dark">{{ ucfirst($e->statut ?? '—') }}</span>
                        @endif
                    </td>
                    <td>{{ $e->email ?? '—' }}</td>
                    <td>{{ $e->telephone ?? '—' }}</td>

                    {{-- ✅ Colonne Code --}}
                    <td>
                        @if($e->code)
                            <span class="badge"
                                  style="background:rgba(240,192,64,0.15);color:#856404;
                                         font-family:monospace;font-size:13px;letter-spacing:1px;">
                                <i class="bi bi-key-fill"></i> {{ $e->code }}
                            </span>
                        @else
                            <span class="text-muted fst-italic small">Non défini</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('enseignants.edit', $e) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('enseignants.destroy', $e) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cet enseignant ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        Aucun enseignant enregistré.
                        <a href="{{ route('enseignants.create') }}">Ajouter un enseignant</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection