<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleEmploye
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'employe') {
            return $next($request);
        }

        // Si pas employé → 403 + message clair
        abort(403, 'Accès refusé. Vous devez être un employé pour accéder à cette section.');
    }
}