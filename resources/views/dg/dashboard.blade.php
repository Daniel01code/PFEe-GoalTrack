@extends('layouts.main')

@section('title', 'Dashboard Directeur Général')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
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

    <div class="max-w-7xl mx-auto">
        <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-6 text-center">
            Dashboard Directeur Général
        </h1>

        <p class="text-xl text-gray-700 mb-12 text-center">
            Bienvenue, {{ auth()->user()->name }}. Gérez les performances de l'entreprise en temps réel.
        </p>

        <!-- Période en cours (restaurée) -->
        @if($periodeEnCours ?? false)
            <div class="inline-block bg-white/20 backdrop-blur-lg rounded-2xl px-8 py-6 mb-12 mx-auto block text-center">
                <p class="text-white text-2xl font-bold">Période en cours</p>
                <p class="text-white text-3xl font-extrabold mt-2">{{ $periodeEnCours->libelle }}</p>
                <p class="text-indigo-100 mt-2">
                    Du {{ \Carbon\Carbon::parse($periodeEnCours->date_debut)->format('d/m/Y') }} 
                    au {{ \Carbon\Carbon::parse($periodeEnCours->date_fin)->format('d/m/Y') }}
                </p>
            </div>
        @else
            <div class="mt-10 text-center">
                <p class="text-gray-800 text-2xl mb-6">Aucune période en cours</p>
                <a href="{{ route('periods.create') }}" class="inline-flex items-center px-10 py-5 bg-indigo-600 text-white text-xl font-bold rounded-2xl hover:bg-indigo-700 transition transform hover:scale-110 shadow-2xl">
                    Démarrer Nouvelle Période
                </a>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Taux d'atteinte global -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <svg class="h-12 w-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-gray-500">Taux d'atteinte global</p>
                        <p class="text-4xl font-bold text-indigo-600">{{ $tauxAtteinte ?? '0' }}%</p>
                    </div>
                </div>
            </div>

            <!-- Services actifs -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H2m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-gray-500">Services actifs</p>
                        <p class="text-4xl font-bold text-green-600">{{ $totalServices ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Employés -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <svg class="h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0-12l5 5 5-5m-10 0l5-5 5 5"></path>
                    </svg>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-gray-500">Employés</p>
                        <p class="text-4xl font-bold text-blue-600">{{ $totalEmployes ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Rapports traités -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                <div class="flex items-center">
                    <svg class="h-12 w-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="ml-6">
                        <p class="text-sm font-medium text-gray-500">Rapports traités</p>
                        <p class="text-4xl font-bold text-purple-600">{{ $totalRapportsSoumis ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Actions rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Objectifs stratégiques -->
                <a href="{{ route('global-goals.create') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-3 duration-300 text-center">
                    <div class="bg-indigo-100 rounded-3xl p-8 mb-6 inline-flex">
                        <svg class="h-20 w-20 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Définir Objectifs Stratégiques</h3>
                    <p class="text-gray-600">Publier les objectifs globaux pour chaque service</p>
                </a>

                <!-- Gestion services -->
                <a href="{{ route('services.index') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-3 duration-300 text-center">
                    <div class="bg-green-100 rounded-3xl p-8 mb-6 inline-flex">
                        <svg class="h-20 w-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gérer Services & Utilisateurs</h3>
                    <p class="text-gray-600">Créer, modifier et organiser les équipes</p>
                </a>

                <!-- Gestion rapports -->
                <a href="{{ route('dg.reports.index') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-3 duration-300 text-center">
                    <div class="bg-purple-100 rounded-3xl p-8 mb-6 inline-flex">
                        <svg class="h-20 w-20 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Gérer les Rapports</h3>
                    <p class="text-gray-600">Valider ou rejeter les rapports soumis par les employés</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection