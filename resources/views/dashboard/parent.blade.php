@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Tableau de bord Parent</h2>
    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>👨‍👩‍👧 Élèves inscrits</h5>
                <p>{{ $elevesCount ?? 0 }}</p>
                <a href="{{ route('eleves.create') }}" class="btn btn-primary">Inscrire un élève</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>📘 Notes et bulletins</h5>
                <p>Consultez les résultats scolaires</p>
                <a href="{{ route('notes.index') }}" class="btn btn-success">Voir les notes</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center p-3">
                <h5>💰 Paiements</h5>
                <p>Suivez vos frais scolaires</p>
                <a href="{{ route('paiements.index') }}" class="btn btn-warning">Payer les frais</a>
            </div>
        </div>
    </div>
</div>
@endsection
