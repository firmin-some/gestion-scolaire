<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $roles = explode('|', $role);

        if (count($roles) > 1) {
            if (! auth()->user()->hasAnyRole($roles)) {
                abort(403, 'Accès non autorisé. Vous n\'avez pas les droits nécessaires.');
            }
        } elseif (! auth()->user()->hasRole($role)) {
            abort(403, 'Accès non autorisé. Vous n\'avez pas les droits nécessaires.');
        }

        return $next($request);
    }
}