@extends('layouts.main')

@section('title', 'Connexion - e-GoalTrack')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden relative">

        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10 relative">
            <h1 class="text-4xl font-extrabold text-white text-center mb-2">Connexion</h1>
            <p class="text-indigo-100 text-center text-lg">Accédez à votre espace e-GoalTrack</p>

            <!-- Décorations -->
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white opacity-10 rounded-full"></div>
        </div>

        <div class="p-8">

            {{-- Message session --}}
            @if(session('status'))
                <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Erreurs --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse Email
                    </label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 bg-gray-50 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 bg-gray-50 shadow-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition">
                </div>

                <!-- Remember me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox"
                               name="remember"
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-600">Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Bouton -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-lg font-bold rounded-2xl shadow-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300">
                        Se connecter
                    </button>
                </div>

                <!-- Lien inscription -->
                <div class="text-center pt-4">
                    <p class="text-gray-600 text-sm">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}"
                           class="text-indigo-600 font-semibold hover:text-indigo-800">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
