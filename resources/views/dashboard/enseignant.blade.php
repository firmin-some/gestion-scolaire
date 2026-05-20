@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Tableau de bord Enseignant</h2>
    <p>Bienvenue, {{ Auth::user()->name }} !</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card text-center p-3">
                <h5>📚 Mes classes</h5>
                <p>Gérez vos classes et élèves</p>
                <a href="{{ route('classes.index') }}" class="btn btn-primary">Voir mes classes</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center p-3">
                <h5>📝 Notes</h5>
                <p>Ajoutez ou modifiez les notes des élèves</p>
                <a href="{{ route('notes.index') }}" class="btn btn-success">Gérer les notes</a>
            </div>
        </div>
    </div>
</div>
@endsection
