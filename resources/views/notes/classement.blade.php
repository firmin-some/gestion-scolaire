@extends('layouts.app')
@section('title', 'Classement des élèves')

@section('content')
<div class="card p-4">
    <h6 class="fw-bold mb-3"><i class="bi bi-trophy-fill text-warning"></i> Classement des élèves</h6>

    <form method="GET" action="{{ route('notes.classement') }}" class="row g-2 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Classe</label>
            <select name="classe_id" class="form-select">
                <option value="">— Choisir —</option>
                @foreach($classes as $classe)
                    <option value="{{ $classe->id }}"
                        {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Trimestre</label>
            <select name="trimestre" class="form-select">
                @foreach(['T1'=>'1er Trimestre','T2'=>'2e Trimestre','T3'=>'3e Trimestre'] as $k=>$v)
                    <option value="{{ $k }}" {{ request('trimestre','T1')==$k?'selected':'' }}>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Afficher
            </button>
        </div>
    </form>

    @if($eleves->isNotEmpty())

    {{-- Style forcé pour ce tableau uniquement --}}
    <style>
        #tableau-classement thead tr th {
            background-color: #1e293b !important;
            color: #f8fafc !important;
            padding: 10px 12px !important;
            font-size: 13px !important;
            border: none !important;
        }
        #tableau-classement tbody tr.top3-row {
            background-color: #fef9c3 !important;
        }
        #tableau-classement tbody tr.top3-row td {
            background-color: #fef9c3 !important;
            color: #1e293b !important;
        }
    </style>

    <table class="table table-hover align-middle" id="tableau-classement">
        <thead>
            <tr>
                <th>Rang</th>
                <th>Élève</th>
                <th>Moyenne générale</th>
                <th>Mention</th>
                <th>Progression</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eleves as $index => $eleve)
            @php
                $notes  = $eleve->notes;
                $moy    = $notes->isNotEmpty() ? round($notes->avg('note'), 2) : null;
                $rang   = $index + 1;
                $medal  = $rang == 1 ? '🥇' : ($rang == 2 ? '🥈' : ($rang == 3 ? '🥉' : $rang));
                $mention = $moy === null ? '—' :
                    ($moy >= 16 ? 'Excellent' :
                    ($moy >= 14 ? 'Bien' :
                    ($moy >= 12 ? 'Assez bien' :
                    ($moy >= 10 ? 'Passable' : 'Insuffisant'))));
                $mentionClass = $moy === null ? 'secondary' :
                    ($moy >= 14 ? 'success' :
                    ($moy >= 10 ? 'warning text-dark' : 'danger'));
            @endphp
            <tr class="{{ $rang <= 3 ? 'top3-row' : '' }}">
                <td>
                    <span class="fs-5">{{ $medal }}</span>
                </td>
                <td>
                    <strong>{{ $eleve->prenom }} {{ $eleve->nom }}</strong>
                </td>
                <td>
                    <span class="fs-5 fw-bold {{ $moy ? ($moy >= 10 ? 'text-success' : 'text-danger') : '' }}">
                        {{ $moy ?? '—' }}
                    </span>
                    <small class="text-muted">/20</small>
                </td>
                <td>
                    <span class="badge bg-{{ $mentionClass }}">{{ $mention }}</span>
                </td>
                <td>
                    <div class="progress" style="height:8px;width:120px">
                        <div class="progress-bar {{ $moy && $moy >= 10 ? 'bg-success' : 'bg-danger' }}"
                             style="width:{{ $moy ? $moy * 5 : 0 }}%"></div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @elseif(request('classe_id'))
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Aucune note saisie pour cette sélection.
        </div>
    @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Sélectionnez une classe et un trimestre pour afficher le classement.
        </div>
    @endif
</div>
@endsection