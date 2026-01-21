@extends('layouts.main')

@section('title', 'Définir Objectifs Stratégiques')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                <h1 class="text-4xl font-bold text-white text-center">Définir les objectifs stratégiques</h1>
                <p class="mt-4 text-indigo-100 text-center text-xl">
                    Période : {{ $periodeEnCours->libelle }}
                </p>
            </div>

            <div class="p-10">
                <p class="text-gray-700 text-lg mb-8 text-center">
                    Saisissez les objectifs globaux pour chaque service.
                </p>

                <form action="{{ route('global-goals.store') }}" method="POST">
                    @csrf

                    <div class="space-y-10">
                        @foreach($services as $service)
                            <div class="bg-gray-50 rounded-2xl p-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $service->nom }}</h3>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Description de l'objectif
                                        </label>
                                        <input type="text" name="objectifs[{{ $service->id }}][description]" 
                                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                               required placeholder="Ex: Augmenter le chiffre d'affaires">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Cible
                                        </label>
                                        <input type="number" name="objectifs[{{ $service->id }}][cible]" 
                                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                               required min="0" placeholder="Ex: 500000">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Unité
                                        </label>
                                        <input type="text" name="objectifs[{{ $service->id }}][unite]" 
                                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                               required placeholder="Ex: FCFA, contrats, clients">
                                        <input type="hidden" name="objectifs[{{ $service->id }}][service_id]" value="{{ $service->id }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12 text-center">
                        <button type="submit" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xl font-bold rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-2xl">
                            <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Publier les objectifs stratégiques
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('dg.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                        ← Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection