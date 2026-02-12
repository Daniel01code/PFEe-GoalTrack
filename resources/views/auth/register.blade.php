@extends('layouts.main')

@section('title', 'Créer un compte - e-GoalTrack')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50 py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden relative">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10 relative">
            <h1 class="text-4xl font-extrabold text-white text-center mb-2">Créer un compte</h1>
            <p class="text-indigo-100 text-center text-lg">Rejoignez e-GoalTrack Enterprise dès aujourd'hui</p>

            <!-- Décorations circulaires -->
            <div class="absolute -top-10 -left-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white opacity-10 rounded-full"></div>
        </div>

        <div class="p-8 space-y-6">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50 shadow-sm transition" />
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50 shadow-sm transition" />
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50 shadow-sm transition" />
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50 shadow-sm transition" />
                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between mt-6">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm mb-4 sm:mb-0">
                        Déjà inscrit ? Se connecter
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-lg font-bold rounded-2xl shadow-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300">
                        S'inscrire
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
