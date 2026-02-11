<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class CustomThrottle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  int  $maxAttempts  Nombre max de tentatives
     * @param  int  $decayMinutes  Fenêtre en minutes (ex : 1 = 60 secondes)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, int $maxAttempts = 3, int $decayMinutes = 1): Response
    {
        $key = 'login:' . $request->ip(); // Limite par IP (ou $request->input('email') pour email)

        // On utilise l'instance RateLimiter correctement (non statique)
        $limiter = app(RateLimiter::class);

        if ($limiter->tooManyAttempts($key, $maxAttempts)) {
            $seconds = $limiter->availableIn($key);

            return redirect()->back()
                ->withErrors(['email' => "Trop de tentatives. Veuillez patienter {$seconds} secondes avant de réessayer."])
                ->withInput($request->only('email'));
        }

        $limiter->hit($key, $decayMinutes * 60); // durée en secondes

        return $next($request);
    }
}