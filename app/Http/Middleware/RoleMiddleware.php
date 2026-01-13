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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        // 1. Vérifier si l'utilisateur est connecté
        // 2. Vérifier si son rôle est présent dans la liste des rôles autorisés
        if (!$request->user() || !in_array($request->user()->role, $roles)) {
            abort(403, "Accès refusé. Rôles autorisés : " . implode(', ', $roles));
        }
        return $next($request);
    }
}
