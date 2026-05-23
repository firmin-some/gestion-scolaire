<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Affiche la page de connexion.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion.
     */
    public function store(Request $request): RedirectResponse
    {
        // ── Connexion Enseignant (nom + code) ──────────────────────────────
        // Détecté soit par login_type='enseignant', soit par présence des champs nom+code
        if ($request->input('login_type') === 'enseignant' || ($request->filled('nom') && $request->filled('code'))) {

            $request->validate([
                'nom'  => 'required|string',
                'code' => 'required|string',
            ], [
                'nom.required'  => 'Le nom est obligatoire.',
                'code.required' => 'Le code de connexion est obligatoire.',
            ]);

            // Cherche avec le nom tel quel OU en majuscules
            $enseignant = Enseignant::where(function ($query) use ($request) {
                            $query->where('nom', $request->nom)
                                  ->orWhere('nom', strtoupper($request->nom));
                        })
                        ->where('code', $request->code)
                        ->first();

            if ($enseignant && $enseignant->user_id) {
                $user = User::find($enseignant->user_id);

                if ($user) {
                    Auth::login($user);
                    $request->session()->regenerate();
                    return redirect()->intended('/dashboard');
                }
            }

            return back()
                ->withInput([
                    'login_type' => 'enseignant',
                    'nom'        => $request->nom,
                ])
                ->withErrors(['nom' => 'Nom ou code de connexion incorrect.']);
        }

        // ── Connexion Gestionnaire / Parent (email + mot de passe) ─────────
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'L\'email est obligatoire.',
            'email.email'       => 'Format d\'email invalide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        if (!Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ], $request->boolean('remember'))) {
            return back()
                ->withInput(['email' => $request->email])
                ->withErrors(['email' => 'Email ou mot de passe incorrect.']);
        }

        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    /**
     * Déconnexion.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}