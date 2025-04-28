<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Récupère le chemin vers lequel l'utilisateur doit être redirigé lorsqu'il n'est pas authentifié.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Renvoie null si la requête attend du JSON, sinon redirige vers la route login
        if ($request->expectsJson()) {
            return null;
        }

        return route('login');
    }
}
