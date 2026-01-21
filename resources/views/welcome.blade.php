@extends('layouts.guest-custom')

@section('title', 'e-GoalTrack Enterprise')

@section('content')
<div class="max-w-7xl mx-auto py-20 px-4 sm:px-6 lg:px-8 text-center">
    <h1 class="text-5xl md:text-6xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-8">
        e-GoalTrack Enterprise
    </h1>
    <p class="text-xl md:text-2xl text-gray-700 mb-12 max-w-3xl mx-auto">
        La plateforme de pilotage par objectifs et reporting automatisé pour votre entreprise.
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-6">
        <a href="{{ route('login') }}" class="inline-block bg-indigo-600 text-white px-10 py-5 rounded-xl font-bold hover:bg-indigo-700 transition text-lg">
            Se connecter
        </a>
        <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-700 px-10 py-5 rounded-xl font-bold border-2 border-indigo-600 hover:bg-indigo-50 transition text-lg">
            Créer un compte
        </a>
    </div>
</div>
@endsection