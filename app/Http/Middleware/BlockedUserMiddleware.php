<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class BlockedUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est authentifié et bloqué
        if (Auth::check() && Auth::user()->is_blocked) {
            Auth::logout(); // Déconnecte l'utilisateur
            return redirect('/login')->with('error', 'Votre compte est bloqué.');
        }

        return $next($request);
    }
}
