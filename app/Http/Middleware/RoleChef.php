<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleChef
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'chef') {
            return $next($request);
        }

        abort(403, 'Accès refusé. Vous devez être Chef de Service.');
    }
}