@extends('layouts.app')
@section('title', 'Nouvelle classe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-plus-circle"></i> Créer une classe</h5>

            <form action="{{ route('classes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Niveau</label>
                    <select name="niveau" class="form-select @error('niveau') is-invalid @enderror">
                        <option value="">— Choisir —</option>
                        @foreach(['CP1','CP2','CE1','CE2','CM1','CM2'] as $n)
                            <option value="{{ $n }}" {{ old('niveau')==$n?'selected':'' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                    @error('niveau')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom de la classe</label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           placeholder="Ex: CP1 A">
                    @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Enseignant titulaire</label>
                    <input type="text" name="enseignant" value="{{ old('enseignant') }}"
                           class="form-control @error('enseignant') is-invalid @enderror"
                           placeholder="Ex: M. OUEDRAOGO">
                    @error('enseignant')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Frais de scolarité annuels (FCFA)</label>
                    <input type="number" name="frais" value="{{ old('frais') }}"
                           class="form-control @error('frais') is-invalid @enderror"
                           placeholder="Ex: 45000">
                    @error('frais')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                    <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection