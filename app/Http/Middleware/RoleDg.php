<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleDg
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'dg') {
            return $next($request);
        }

        abort(403, 'Accès refusé. Vous devez être Directeur Général.');
    }
}