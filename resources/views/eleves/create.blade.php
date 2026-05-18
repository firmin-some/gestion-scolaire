@extends('layouts.app')
@section('title', 'Inscrire un élève')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-plus"></i> Inscrire un nouvel élève</h5>

            <form action="{{ route('eleves.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}"
                               class="form-control @error('prenom') is-invalid @enderror"
                               placeholder="Ex: Aminata">
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex: OUEDRAOGO">
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sexe</label>
                        <select name="sexe" class="form-select @error('sexe') is-invalid @enderror">
                            <option value="M" {{ old('sexe')=='M'?'selected':'' }}>Masculin</option>
                            <option value="F" {{ old('sexe')=='F'?'selected':'' }}>Féminin</option>
                        </select>
                        @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Classe</label>
                        <select name="classe_id" class="form-select @error('classe_id') is-invalid @enderror">
                            <option value="">— Choisir —</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}"
                                    {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom du parent / tuteur</label>
                        <input type="text" name="nom_parent" value="{{ old('nom_parent') }}"
                               class="form-control @error('nom_parent') is-invalid @enderror"
                               placeholder="Ex: Idrissa OUEDRAOGO">
                        @error('nom_parent')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone parent</label>
                        <input type="text" name="telephone_parent" value="{{ old('telephone_parent') }}"
                               class="form-control" placeholder="Ex: 70 00 00 00">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Photo de l'élève</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                        <div class="form-text">Optionnel. JPG, PNG. Max 2MB.</div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                    <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection