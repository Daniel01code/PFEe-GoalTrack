@extends('layouts.guest-custom')

@section('title', 'e-GoalTrack Enterprise')

@section('content')
<div class="relative overflow-hidden bg-gray-50 min-h-screen flex items-center justify-center">
    <!-- Décorations abstraites -->
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[80rem] h-[80rem] bg-gradient-to-r from-indigo-400 to-purple-600 rounded-full opacity-20 animate-pulse-slow"></div>
    <div class="absolute bottom-0 right-0 w-[50rem] h-[50rem] bg-gradient-to-tr from-pink-400 to-indigo-500 rounded-full opacity-15 animate-pulse-slow"></div>

    <div class="relative z-10 max-w-7xl mx-auto py-24 px-6 sm:px-6 lg:px-8 text-center">
        <!-- Titre principal -->
        <h1 class="text-5xl md:text-7xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-6 drop-shadow-lg">
            e-GoalTrack Enterprise
        </h1>

        <!-- Sous-titre -->
        <p class="text-lg md:text-2xl text-gray-700 mb-12 max-w-3xl mx-auto leading-relaxed">
            La plateforme ultime de pilotage par objectifs et reporting automatisé pour votre entreprise. 
            Suivez, analysez et optimisez la performance de vos équipes en toute simplicité.
        </p>

        <!-- Boutons principaux -->
        <div class="flex flex-col sm:flex-row justify-center gap-6">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center justify-center px-12 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg rounded-2xl shadow-xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300">
                Se connecter
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>

            <a href="{{ route('register') }}" 
               class="inline-flex items-center justify-center px-12 py-5 bg-white text-indigo-700 font-bold text-lg rounded-2xl border-2 border-indigo-600 shadow hover:bg-indigo-50 transform hover:scale-105 transition duration-300">
                Créer un compte
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </a>
        </div>

        <!-- Petit texte en bas -->
        <p class="mt-12 text-gray-500 text-sm max-w-md mx-auto">
            &copy; {{ date('Y') }} e-GoalTrack Enterprise. Tous droits réservés.
        </p>
    </div>
</div>

<!-- Animation Pulse lente -->
<style>
@keyframes pulse-slow {
    0%, 100% { transform: scale(1) translate(0,0); opacity: 0.2; }
    50% { transform: scale(1.1) translate(10px, -10px); opacity: 0.3; }
}
.animate-pulse-slow {
    animation: pulse-slow 12s infinite;
}
</style>
@endsection
