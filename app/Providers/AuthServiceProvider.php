<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Enregistre les services d'authentification et d'autorisation.
     */
    public function boot(): void
    {
        // Définir un Gate pour empêcher les utilisateurs bloqués d'accéder
        Gate::define('access-dashboard', function ($user) {
            return !$user->is_blocked; // Vérifie si l'utilisateur est bloqué
        });
    }
}
