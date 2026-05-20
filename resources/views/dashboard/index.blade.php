@extends('layouts.dashboard')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h2 class="mb-3">Bienvenue sur EcolePrime 🎓</h2>
            <p class="text-muted">
                Votre rôle n’a pas été reconnu ou aucun rôle n’est attribué à votre compte.
            </p>
            <p>
                Veuillez contacter l’administrateur pour obtenir les accès appropriés.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Retour à l’accueil</a>
        </div>
    </div>
</div>
@endsection
