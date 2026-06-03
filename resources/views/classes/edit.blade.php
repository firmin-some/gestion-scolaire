@extends('layouts.app')
@section('title', 'Modifier la classe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-pencil"></i> Modifier la classe</h5>

            <form action="{{ url('classes/' . $classe->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Niveau</label>
                    <select name="niveau" class="form-select">
                        @foreach(['CP1','CP2','CE1','CE2','CM1','CM2'] as $n)
                            <option value="{{ $n }}" {{ $classe->niveau==$n?'selected':'' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nom de la classe</label>
                    <input type="text" name="nom" value="{{ $classe->nom }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Enseignant titulaire</label>
                    <input type="text" name="enseignant" value="{{ $classe->enseignant }}" class="form-control">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Frais annuels (FCFA)</label>
                    <input type="number" name="frais" value="{{ $classe->frais }}" class="form-control">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Mettre à jour
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