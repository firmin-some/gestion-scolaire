@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')

{{-- Statistiques principales --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card stat-card green p-3">
            <div class="text-muted small">💵 Frais collectés</div>
            <div class="fs-4 fw-bold text-success">{{ number_format($fraisCollecte, 0, ',', ' ') }} FCFA</div>
            <div class="text-muted small">{{ $tauxCollecte }}% collecté</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card blue p-3">
            <div class="text-muted small">🏦 Frais attendus</div>
            <div class="fs-4 fw-bold text-primary">{{ number_format($fraisAttendu, 0, ',', ' ') }} FCFA</div>
            <div class="text-muted small">Total attendu</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card red p-3">
            <div class="text-muted small">⚠️ Élèves impayés</div>
            <div class="fs-4 fw-bold text-danger">{{ $elevesImpayes->count() }}</div>
            <div class="text-muted small">avec solde restant</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card gold p-3">
            <div class="text-muted small">🎓 Élèves inscrits</div>
            <div class="fs-4 fw-bold" style="color:#f0c040">{{ $totalEleves }}</div>
            <div class="text-muted small">{{ $totalClasses }} classes</div>
        </div>
    </div>
</div>

{{-- Lien inscription parent --}}
<div class="card p-4 mb-4">
    <h6 class="fw-bold mb-2">🔗 Lien d'inscription parent</h6>
    <p class="text-muted small">Envoyez ce lien aux parents pour qu'ils puissent s'inscrire eux-mêmes.</p>
    <div class="input-group">
        <input type="text" class="form-control" id="lienInscription"
               value="{{ url('/register') }}" readonly>
        <button class="btn btn-outline-secondary" onclick="copyLien()">Copier</button>
    </div>
    <small class="text-muted mt-1 d-block">
        Ce lien doit être envoyé aux parents. Si vous êtes déjà connecté en tant que gestionnaire,
        la page /register vous redirigera vers le tableau de bord.
        Ouvrez-le depuis un autre navigateur, une fenêtre privée ou envoyez-le directement au parent.
    </small>
</div>

{{-- Parents d'élèves --}}
<div class="card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">👨‍👩‍👧 Parents d'élèves</h6>
        <span class="badge bg-secondary">{{ $totalParents }} parents</span>
    </div>
    @if($parents->isEmpty())
        <p class="text-muted text-center py-3">Aucun parent inscrit avec un enfant.</p>
    @else
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th style="background:#1e293b;color:#f8fafc !important;">Parent</th>
                <th style="background:#1e293b;color:#f8fafc !important;">Email</th>
                <th style="background:#1e293b;color:#f8fafc !important;">Nb enfants</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parents as $parent)
            <tr>
                <td><strong>{{ $parent->name }}</strong></td>
                <td>{{ $parent->email }}</td>
                <td><span class="badge bg-primary">{{ $parent->eleves_count }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

{{-- Enseignants --}}
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">👩‍🏫 Enseignants</h6>
        <a href="{{ route('enseignants.index') }}" class="btn btn-sm btn-primary">Gérer</a>
    </div>
    @php $enseignants = \App\Models\User::role('Enseignant')->get(); @endphp
    @if($enseignants->isEmpty())
        <p class="text-muted text-center py-3">Aucun enseignant enregistré.</p>
    @else
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th style="background:#1e293b;color:#f8fafc !important;">Nom</th>
                <th style="background:#1e293b;color:#f8fafc !important;">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enseignants as $ens)
            <tr>
                <td><strong>{{ $ens->name }}</strong></td>
                <td>{{ $ens->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection

@section('scripts')
<script>
function copyLien() {
    const input = document.getElementById('lienInscription');
    input.select();
    document.execCommand('copy');
    alert('Lien copié !');
}
</script>
@endsection