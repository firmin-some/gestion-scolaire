@extends('layouts.app')
@section('title', 'Ajouter un enseignant')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-plus"></i> Ajouter un enseignant</h5>
            <form action="{{ route('enseignants.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}"
                               class="form-control @error('prenom') is-invalid @enderror"
                               placeholder="Ex: Moussa">
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
                        <label class="form-label fw-semibold">Sexe</label>
                        <select name="sexe" class="form-select @error('sexe') is-invalid @enderror">
                            <option value="M" {{ old('sexe')=='M'?'selected':'' }}>Masculin</option>
                            <option value="F" {{ old('sexe')=='F'?'selected':'' }}>Féminin</option>
                        </select>
                        @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                               class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Spécialité / Matière</label>
                        <select name="specialite" class="form-select">
                            <option value="">— Choisir —</option>
                            @foreach(['Français','Mathématiques','Sciences','Histoire-Géo','Anglais','EPS','Toutes matières'] as $s)
                                <option value="{{ $s }}" {{ old('specialite')==$s?'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Ex: enseignant@ecole.bf">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}"
                               class="form-control" placeholder="Ex: 70 00 00 00">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                    <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection