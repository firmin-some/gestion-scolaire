@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Tableau de bord Gestionnaire</h2>
    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>💵 Paiements</h5>
                <p>Suivez les transactions et frais collectés</p>
                <a href="{{ route('paiements.index') }}" class="btn btn-warning">Voir les paiements</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>🏫 Classes</h5>
                <p>Gérez les classes et les frais associés</p>
                <a href="{{ route('classes.index') }}" class="btn btn-primary">Gérer les classes</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>👩‍🏫 Enseignants</h5>
                <p>Gérez le personnel enseignant</p>
                <a href="{{ route('enseignants.index') }}" class="btn btn-info">Voir les enseignants</a>
            </div>
        </div>
    </div>
</div>
@endsection
