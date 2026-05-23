<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Onglets --}}
    <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ old('login_type') === 'enseignant' || $errors->has('nom') || $errors->has('code') ? '' : 'active' }}"
               data-bs-toggle="tab" href="#tab-email" role="tab">
                <i class="bi bi-person-badge"></i> Gestionnaire / Parent
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ old('login_type') === 'enseignant' || $errors->has('nom') || $errors->has('code') ? 'active' : '' }}"
               data-bs-toggle="tab" href="#tab-enseignant" role="tab">
                <i class="bi bi-chalkboard-teacher"></i> Enseignant
            </a>
        </li>
    </ul>

    {{-- Erreurs globales --}}
    @if($errors->any())
        <div class="alert alert-danger py-2 mb-3">
            @foreach($errors->all() as $error)
                <div><i class="bi bi-exclamation-circle"></i> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="tab-content" id="loginTabsContent">

        {{-- ── Onglet Gestionnaire / Parent ── --}}
        <div class="tab-pane fade {{ old('login_type') === 'enseignant' || $errors->has('nom') || $errors->has('code') ? '' : 'show active' }}"
             id="tab-email" role="tabpanel">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="login_type" value="email">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="admin@ecoleprime.bf" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mot de passe</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label text-muted" for="remember">Se souvenir de moi</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-muted text-decoration-underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login-gestionnaire">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                </button>
            </form>
        </div>

        {{-- ── Onglet Enseignant ── --}}
        <div class="tab-pane fade {{ old('login_type') === 'enseignant' || $errors->has('nom') || $errors->has('code') ? 'show active' : '' }}"
             id="tab-enseignant" role="tabpanel">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="login_type" value="enseignant">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-person"></i> Nom de famille
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="form-control @error('nom') is-invalid @enderror"
                           placeholder="Ex: OUEDRAOGO" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-key"></i> Code de connexion
                    </label>
                    <input type="text" name="code"
                           class="form-control @error('code') is-invalid @enderror"
                           placeholder="Ex: ENS-001" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login-enseignant mt-2">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter (Enseignant)
                </button>
            </form>
        </div>

    </div>

</x-guest-layout>