@extends('layouts.app')
@section('title', 'Parents d\'élèves')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h4 mb-1">Parents d'élèves</h1>
        <p class="text-muted mb-0">Liste des parents inscrits et le nombre d'enfants associés.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Retour au tableau de bord</a>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Enfants</th>
                </tr>
            </thead>
            <tbody>
                @forelse($parents as $parent)
                <tr>
                    <td>{{ $parent->id }}</td>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent->eleves_count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Aucun parent trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
