<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcolePrime — @yield('title', 'Gestion Scolaire')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #1a1a2e;
            width: 240px;
            position: fixed;
            top: 0; left: 0;
            padding-top: 20px;
            z-index: 100;
        }
        .sidebar .brand {
            color: #f0c040;
            font-size: 20px;
            font-weight: 700;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: block;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #f0c040;
            background: rgba(240,192,64,0.1);
            border-left: 3px solid #f0c040;
        }
        .sidebar .nav-label {
            color: rgba(255,255,255,0.3);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 20px 6px;
        }
        .main-content {
            margin-left: 240px;
            padding: 24px;
        }
        .topbar {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 24px;
            margin-left: 240px;
            position: sticky;
            top: 0;
            z-index: 99;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); border-radius: 12px; }
        .stat-card { border-left: 4px solid; }
        .stat-card.gold { border-color: #f0c040; }
        .stat-card.green { border-color: #28a745; }
        .stat-card.red { border-color: #dc3545; }
        .stat-card.blue { border-color: #007bff; }
        .btn-primary { background: #1a1a2e; border-color: #1a1a2e; }
        .btn-primary:hover { background: #f0c040; border-color: #f0c040; color: #000; }
        .table th { background: #f8f9fa; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-solde { background: rgba(40,167,69,0.15); color: #28a745; }
        .badge-partiel { background: rgba(255,193,7,0.15); color: #856404; }
        .badge-nonpaye { background: rgba(220,53,69,0.15); color: #dc3545; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    <span class="brand">🏫 EcolePrime</span>

    <div class="nav-label">Principal</div>
    <a href="{{ route('dashboard') }}"
       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-fill"></i> Tableau de bord
    </a>

    <div class="nav-label">Administratif</div>
    <a href="{{ route('eleves.index') }}"
       class="nav-link {{ request()->routeIs('eleves.*') ? 'active' : '' }}">
        <i class="bi bi-people-fill"></i> Élèves
    </a>
    <a href="{{ route('classes.index') }}"
       class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}">
        <i class="bi bi-building"></i> Classes & Frais
    </a>
    <a href="{{ route('paiements.index') }}"
       class="nav-link {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
        <i class="bi bi-cash-coin"></i> Paiements
    </a>

    <div class="nav-label">Pédagogique</div>
    <a href="{{ route('notes.index') }}"
       class="nav-link {{ request()->routeIs('notes.index') ? 'active' : '' }}">
        <i class="bi bi-pencil-fill"></i> Notes
    </a>
    <a href="{{ route('notes.moyennes') }}"
       class="nav-link {{ request()->routeIs('notes.moyennes') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-fill"></i> Moyennes
    </a>
    <a href="{{ route('notes.classement') }}"
       class="nav-link {{ request()->routeIs('notes.classement') ? 'active' : '' }}">
        <i class="bi bi-trophy-fill"></i> Classement
    </a>

    <div class="nav-label">Compte</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
            <i class="bi bi-box-arrow-left"></i> Déconnexion
        </button>
    </form>
</div>

{{-- TOPBAR --}}
<div class="topbar">
    <h6 class="mb-0 fw-bold">@yield('title', 'Tableau de bord')</h6>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-warning text-dark">{{ auth()->user()->role ?? 'gestionnaire' }}</span>
        <strong>{{ auth()->user()->name ?? '' }}</strong>
    </div>
</div>

{{-- CONTENU --}}
<div class="main-content">
    {{-- Alertes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>