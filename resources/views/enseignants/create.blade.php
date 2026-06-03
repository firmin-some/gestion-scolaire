@extends('layouts.app')
@section('title', 'Ajouter un enseignant')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-plus"></i> Ajouter un enseignant</h5>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('enseignants.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Prénom</label>
                        <input type="text" name="prenom" value="{{ old('prenom') }}"
                               class="form-control @error('prenom') is-invalid @enderror"
                               placeholder="Ex: Moussa" required>
                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nom</label>
                        <input type="text" name="nom" value="{{ old('nom') }}"
                               class="form-control @error('nom') is-invalid @enderror"
                               placeholder="Ex: OUEDRAOGO" required>
                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Sexe</label>
                        <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                            <option value="">— Choisir —</option>
                            <option value="M" {{ old('sexe')=='M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('sexe')=='F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                        @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Date de naissance</label>
                        <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                               class="form-control @error('date_naissance') is-invalid @enderror" required>
                        @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Spécialité / Matière</label>
                        <select name="specialite" class="form-select @error('specialite') is-invalid @enderror" required>
                            <option value="">— Choisir —</option>
                            @foreach($subjects as $value => $label)
                                <option value="{{ $value }}" {{ old('specialite') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('specialite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Classe</label>
                        <select name="classe_id" class="form-select @error('classe_id') is-invalid @enderror" required>
                            <option value="">— Choisir —</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->niveau }} - {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text text-muted">
                            Si la classe n'a pas encore de titulaire, cet enseignant sera défini comme titulaire. Sinon il sera enregistré comme secondaire.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Ex: enseignant@ecole.bf" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Téléphone</label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}"
                               class="form-control @error('telephone') is-invalid @enderror"
                               placeholder="Ex: 70 00 00 00">
                        @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Code de connexion --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-key"></i> Code de connexion
                        </label>
                        <input type="text" name="code" value="{{ old('code') }}"
                               class="form-control @error('code') is-invalid @enderror"
                               placeholder="Ex: ENS-001" required>
                        @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle"></i>
                            Ce code sera utilisé par l'enseignant pour se connecter avec son nom.
                            Conservez-le et transmettez-le à l'enseignant.
                        </div>
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