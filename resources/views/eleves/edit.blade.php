@extends('layouts.app')
@section('title', 'Modifier l\'élève')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-pencil"></i> Modifier l'élève</h5>

            <form action="{{ route('eleves.update', $eleve) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prénom</label>
                        <input type="text" name="prenom" value="{{ $eleve->prenom }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom</label>
                        <input type="text" name="nom" value="{{ $eleve->nom }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de naissance</label>
                        <input type="date" name="date_naissance"
                               value="{{ $eleve->date_naissance?->format('Y-m-d') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sexe</label>
                        <select name="sexe" class="form-select">
                            <option value="M" {{ $eleve->sexe=='M'?'selected':'' }}>Masculin</option>
                            <option value="F" {{ $eleve->sexe=='F'?'selected':'' }}>Féminin</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Classe</label>
                        <select name="classe_id" class="form-select">
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ $eleve->classe_id == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom du parent</label>
                        <input type="text" name="nom_parent" value="{{ $eleve->nom_parent }}" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone parent</label>
                        <input type="text" name="telephone_parent" value="{{ $eleve->telephone_parent }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Nouvelle photo (optionnel)</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        @if($eleve->photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$eleve->photo) }}"
                                     width="80" class="rounded">
                                <small class="text-muted ms-2">Photo actuelle</small>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à jour
                    </button>
                    <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection