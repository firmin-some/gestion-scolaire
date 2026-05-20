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
                    <th>Email</th>
                    <th>Téléphone</th>
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
                            <span class="badge bg-primary">{{ $e->specialite }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $e->email ?? '—' }}</td>
                    <td>{{ $e->telephone ?? '—' }}</td>
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
                    <td colspan="7" class="text-center text-muted py-4">
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