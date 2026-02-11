<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $key = strtolower($request->email).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 2)) {
            $seconds = RateLimiter::availableIn($key);
            throw
            ValidationException::withMessages(['email' => "Trop de tentatives. Veuillez patienter {$seconds} secondes avant de réessayer."]);

        }

        if(!Auth::attempt($request->only('email','password'),$request->boolean('remember') ) )
        {
            RateLimiter::hit($key, 30); // Incrémente le compteur pour 60 secondes

            throw
            ValidationException::withMessages(['email' => "identifiants invalides."]);

        }
        $request->authenticate();
        
        RateLimiter::clear($key); 

        $request->session()->regenerate();

        if(auth()->user()->role === 'dg')
        {
            return redirect()->route('dg.dashboard') ;
        }elseif(auth()->user()->role === 'chef')
        {
            return redirect()->route('chef.dashboard') ;
        }elseif(auth()->user()->role === 'employe')
        {
            return redirect()->route('employee.dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
