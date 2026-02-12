@extends('layouts.main')

@section('title', 'Définir Objectifs Stratégiques')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">

        <!-- Header avec dégradé et décorations -->
        <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-10 text-white text-center overflow-hidden mb-12">
            <!-- Décorations circulaires -->
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white opacity-10 rounded-full"></div>
            <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-5 rounded-full"></div>

            <!-- Texte -->
            <p class="text-2xl font-semibold mb-2 tracking-wide uppercase">Période en cours</p>
            <p class="text-4xl font-extrabold mb-2">{{ $periodeEnCours->libelle }}</p>
            <p class="text-lg text-indigo-100 mb-4">
                Du <span class="font-medium">{{ $periodeEnCours->date_debut->format('d/m/Y') }}</span>
                au <span class="font-medium">{{ $periodeEnCours->date_fin->format('d/m/Y') }}</span>
            </p>
            <p class="text-lg text-indigo-100">
                Définissez ou modifiez les objectifs stratégiques pour chaque service
            </p>
        </div>

        <!-- Formulaire Objectifs Globaux -->
        <form action="{{ route('global-goals.store') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-8">
                @foreach($services as $service)
                    <div class="bg-white rounded-3xl shadow-lg p-8 hover:shadow-2xl transition-shadow duration-300">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $service->nom }}</h3>
                            <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 font-medium text-sm">Service</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <input type="text" 
                                       name="objectifs[{{ $service->id }}][description]" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50"
                                       required
                                       value="{{ old('objectifs.'.$service->id.'.description', $objectifs[$service->id]->description ?? '') }}"
                                       placeholder="Ex: Augmenter le chiffre d'affaires">
                            </div>

                            <!-- Cible -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cible</label>
                                <input type="number" 
                                       name="objectifs[{{ $service->id }}][cible]" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50"
                                       required min="0"
                                       value="{{ old('objectifs.'.$service->id.'.cible', $objectifs[$service->id]->cible ?? '') }}"
                                       placeholder="Ex: 500000">
                            </div>

                            <!-- Unité -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unité</label>
                                <input type="text" 
                                       name="objectifs[{{ $service->id }}][unite]" 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 bg-gray-50"
                                       required
                                       value="{{ old('objectifs.'.$service->id.'.unite', $objectifs[$service->id]->unite ?? '') }}"
                                       placeholder="Ex: FCFA, contrats, clients">
                                <input type="hidden" name="objectifs[{{ $service->id }}][service_id]" value="{{ $service->id }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bouton submit -->
            <div class="mt-12 text-center">
                <button type="submit" 
                        class="inline-flex items-center px-14 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xl font-bold rounded-3xl shadow-lg hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition duration-300">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Publier / Mettre à jour
                </button>
            </div>
        </form>

        <!-- Retour -->
        <div class="mt-10 text-center">
            <a href="{{ route('dg.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                ← Retour au dashboard
            </a>
        </div>
    </div>
</div>
@endsection
