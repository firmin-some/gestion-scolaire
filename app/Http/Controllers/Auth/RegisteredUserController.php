<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la requête d'inscription.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 🔐 Attribution automatique du rôle Parent
        $user->assignRole('Parent');

        event(new Registered($user));
        Auth::login($user);

        // 🔀 Redirection selon le rôle
        if ($user->hasRole('Parent')) {
            return redirect()->route('dashboard.parent');
        } elseif ($user->hasRole('Enseignant')) {
            return redirect()->route('dashboard.enseignant');
        } elseif ($user->hasRole('Gestionnaire')) {
            return redirect()->route('dashboard.gestionnaire');
        }

        // Fallback si aucun rôle n'est trouvé
        return redirect()->route('dashboard.index');
    }
}
