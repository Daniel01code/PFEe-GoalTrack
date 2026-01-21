@extends('layouts.main')

@section('title', 'Dashboard Chef de Service')

@section('content')
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <!-- Messages flash -->
        @if(session('error'))
            <div class="mb-8 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-8 bg-blue-100 border border-blue-400 text-blue-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('info') }}
            </div>
        @endif

        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
                Dashboard Chef de Service - {{ auth()->user()->service->nom ?? 'Service non défini' }}
            </h1>

            @if($periodeEnCours ?? false)
                <div class="bg-indigo-100 rounded-2xl p-6 mb-10 text-center">
                    <p class="text-2xl font-bold text-indigo-800">Période en cours : {{ $periodeEnCours->libelle }}</p>
                </div>
            @else
                <div class="bg-yellow-100 rounded-2xl p-6 mb-10 text-center">
                    <p class="text-2xl font-bold text-yellow-800">Aucune période en cours</p>
                </div>
            @endif

            <h2 class="text-3xl font-bold text-gray-900 mb-8">Objectifs stratégiques de votre service</h2>

            @if($objectifsGlobaux->isEmpty())
                <p class="text-center text-gray-600 text-xl">Aucun objectif stratégique publié pour cette période.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($objectifsGlobaux as $objectif)
                        <div class="bg-white rounded-2xl shadow-2xl p-8">
                            <h3 class="text-2xl font-bold text-indigo-600 mb-4">{{ $objectif->description }}</h3>
                            <p class="text-lg text-gray-700 mb-2">
                                <span class="font-semibold">Cible globale :</span> {{ $objectif->cible }} {{ $objectif->unite }}
                            </p>

                            @if($objectif->objectifsIndividuels->count() > 0)
                                <p class="text-green-600 font-semibold mb-4">Déjà décliné en objectifs individuels</p>
                            @else
                                <a href="{{ route('individual-goals.create', $objectif->id) }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition">
                                    Décliner en objectifs individuels
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Actions rapides -->
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Actions rapides</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    <!-- Bouton Validation des rapports -->
                    <a href="{{ route('reports.index') }}" class="group bg-white rounded-3xl shadow-2xl p-10 hover:shadow-3xl transition transform hover:-translate-y-2 duration-300 text-center">
                        <div class="bg-green-100 rounded-3xl p-8 mb-6 inline-flex">
                            <svg class="h-20 w-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Valider les rapports</h3>
                        <p class="text-gray-600">Vérifier et valider/rejeter les rapports soumis</p>
                    </a>

                    <!-- Autres boutons futurs si tu veux -->
                    <div class="bg-white rounded-3xl shadow-2xl p-10 opacity-50 cursor-not-allowed text-center">
                        <div class="bg-gray-100 rounded-3xl p-8 mb-6 inline-flex">
                            <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-400 mb-4">Autres actions (bientôt)</h3>
                        <p class="text-gray-500">Fonctionnalités en cours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection