@extends('layouts.main')

@section('title', 'Dashboard Directeur Général')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-8 bg-blue-100 border border-blue-400 text-blue-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('info') }}
            </div>
        @endif

        <!-- Titre -->
        <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-6 text-center">
            Dashboard Directeur Général
        </h1>

        <p class="text-xl text-gray-700 mb-12 text-center">
            Bienvenue, {{ auth()->user()->name }}. Pilotez les performances de l'entreprise.
        </p>

        <!-- Section Période (toujours visible) -->
        <div class="mb-16">
            @if($periodeEnCours)
                <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-10 text-white text-center overflow-hidden">
                    <!-- Décorations circulaires -->
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                    <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white opacity-10 rounded-full"></div>

                    <p class="text-2xl font-semibold mb-2 tracking-wide uppercase">Période en cours</p>
                    <p class="text-4xl font-extrabold mb-4">{{ $periodeEnCours->libelle }}</p>
                    <p class="text-lg text-indigo-100 mb-8">
                        Du <span class="font-medium">{{ $periodeEnCours->date_debut->format('d/m/Y') }}</span> 
                        au <span class="font-medium">{{ $periodeEnCours->date_fin->format('d/m/Y') }}</span>
                    </p>

                    <div class="flex flex-col md:flex-row justify-center gap-6">
                        <!-- Clôturer et démarrer -->
                        <a href="{{ route('periods.create') }}" 
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-700 font-bold text-lg rounded-2xl shadow-lg hover:bg-gray-100 hover:scale-105 transition transform">
                            Clôturer & Démarrer Nouvelle Période
                        </a>

                        <!-- Modifier la période actuelle -->
                        <a href="{{ route('dg.editPeriode') }}" 
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-indigo-700 font-bold text-lg rounded-2xl shadow-lg hover:bg-gray-100 hover:scale-105 transition transform">
                            Modifier la période actuelle
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-2 border-yellow-400 rounded-3xl p-10 text-center shadow-lg">
                    <p class="text-2xl font-bold text-yellow-800 mb-6 tracking-wide">Aucune période en cours</p>
                    <a href="{{ route('periods.create') }}" 
                    class="inline-flex items-center justify-center px-10 py-5 bg-yellow-600 text-white text-xl font-bold rounded-2xl shadow-lg hover:bg-yellow-700 hover:scale-105 transition transform">
                        Démarrer Nouvelle Période
                    </a>
                </div>
            @endif
        </div>


        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="flex items-center justify-center flex-col text-center">
                    <svg class="h-16 w-16 text-indigo-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Taux d'atteinte global</p>
                    <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $tauxAtteinte }}%</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="flex items-center justify-center flex-col text-center">
                    <svg class="h-16 w-16 text-green-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H2m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Services actifs</p>
                    <p class="text-4xl font-bold text-green-600 mt-2">{{ $totalServices }}</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="flex items-center justify-center flex-col text-center">
                    <svg class="h-16 w-16 text-blue-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0-12l5 5 5-5m-10 0l5-5 5 5"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Employés</p>
                    <p class="text-4xl font-bold text-blue-600 mt-2">{{ $totalEmployes }}</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="flex items-center justify-center flex-col text-center">
                    <svg class="h-16 w-16 text-purple-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm font-medium text-gray-500">Rapports traités</p>
                    <p class="text-4xl font-bold text-purple-600 mt-2">{{ $totalRapportsSoumis }}</p>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Actions rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <a href="{{ route('global-goals.create') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-3 duration-300 text-center">
                    <div class="bg-indigo-100 rounded-3xl p-8 mb-6 inline-flex">
                        <svg class="h-20 w-20 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Objectifs Stratégiques</h3>
                    <p class="text-gray-600">Publier les objectifs globaux</p>
                </a>

                <a href="{{ route('services.index') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-3 duration-300 text-center">
                    <div class="bg-green-100 rounded-3xl p-8 mb-6 inline-flex">
                        <svg class="h-20 w-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Services & Utilisateurs</h3>
                    <p class="text-gray-600">Gérer les équipes</p>
                </a>

                <a href="{{ route('dg.reports.index') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-3 duration-300 text-center">
                    <div class="bg-purple-100 rounded-3xl p-8 mb-6 inline-flex">
                        <svg class="h-20 w-20 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gérer les Rapports</h3>
                    <p class="text-gray-600">Valider et consulter</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection