<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Gère la vérification des rôles utilisateur.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|array $roles
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response|RedirectResponse
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        if (!in_array($userRole, $roles)) {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Accès non autorisé pour ce rôle.',
            ]);
        }

        return $next($request);
    }
}
