<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {

        // 1. Vérifier si l'utilisateur est connecté
        // 2. Vérifier si son rôle correspond à celui attendu
        if (!$request->user() || $request->user()->role !== $role) {
            // Si non, on redirige ou on affiche une erreur 403 (Interdit)
            abort(403, "Accès refusé : vous n'êtes pas " . $role);
        }
        return $next($request);
    }
}
