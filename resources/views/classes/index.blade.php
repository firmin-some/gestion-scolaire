@extends('layouts.app')
@section('title', 'Classes & Frais')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-building"></i> Classes configurées</h5>
    <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Nouvelle classe
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Classe</th>
                    <th>Niveau</th>
                    <th>Enseignant</th>
                    <th>Frais annuels</th>
                    <th>Nb élèves</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($classes as $classe)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $classe->nom }}</strong></td>
                    <td><span class="badge bg-primary">{{ $classe->niveau }}</span></td>
                    <td>{{ $classe->enseignant }}</td>
                    <td>{{ number_format($classe->frais, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $classe->eleves_count }} élève(s)</td>
                    <td>
                        <a href="{{ route('classes.edit', $classe->id) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('classes.destroy', $classe->id) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Supprimer cette classe ?')">
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
                        Aucune classe configurée.
                        <a href="{{ route('classes.create') }}">Créer une classe</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection