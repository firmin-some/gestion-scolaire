@extends('layouts.app')
@section('title', 'Modifier enseignant')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-pencil"></i> Modifier l'enseignant</h5>
            <form action="{{ route('enseignants.update', $enseignant) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prénom</label>
                        <input type="text" name="prenom" value="{{ $enseignant->prenom }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom</label>
                        <input type="text" name="nom" value="{{ $enseignant->nom }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sexe</label>
                        <select name="sexe" class="form-select">
                            <option value="M" {{ $enseignant->sexe=='M'?'selected':'' }}>Masculin</option>
                            <option value="F" {{ $enseignant->sexe=='F'?'selected':'' }}>Féminin</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de naissance</label>
                        <input type="date" name="date_naissance"
                              value="{{ $enseignant->date_naissance ? \Carbon\Carbon::parse($enseignant->date_naissance)->format('Y-m-d') : '' }}"
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Spécialité</label>
                        <select name="specialite" class="form-select">
                            <option value="">— Choisir —</option>
                            @foreach(\App\Models\Enseignant::specialiteLabels() as $value => $label)
                                <option value="{{ $value }}" {{ $enseignant->specialite == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ $enseignant->email }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone</label>
                        <input type="text" name="telephone" value="{{ $enseignant->telephone }}" class="form-control">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à jour
                    </button>
                    <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection