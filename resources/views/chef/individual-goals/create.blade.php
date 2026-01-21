@extends('layouts.main')

@section('title', 'Décliner Objectif en Individuel')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                <h1 class="text-4xl font-bold text-white text-center">Décliner l'objectif en individuel</h1>
            </div>

            <div class="p-10">
                <!-- Objectif global -->
                <div class="bg-indigo-50 rounded-2xl p-6 mb-8">
                    <p class="text-xl font-semibold text-indigo-800">Objectif global</p>
                    <p class="text-2xl font-bold text-indigo-600 mt-2">{{ $objectifGlobal->description }}</p>
                    <p class="text-gray-700 mt-2 text-lg">
                        Cible globale : {{ $objectifGlobal->cible }} {{ $objectifGlobal->unite }}
                    </p>
                </div>

                <!-- Formulaire -->
                <form action="{{ route('individual-goals.store', $objectifGlobal->id) }}" method="POST">
                    @csrf

                    @if($employes->isEmpty())
                        <p class="text-center text-gray-600 text-xl mb-8">Aucun employé dans ce service.</p>
                    @else
                        <p class="text-center text-gray-600 mb-6">
                            Assignation pour {{ $employes->total() }} employé(s) — Page {{ $employes->currentPage() }} / {{ $employes->lastPage() }}
                        </p>

                        <div class="space-y-8">
                            @foreach($employes as $employe)
                                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ $employe->name }}</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Cible personnelle
                                            </label>
                                            <input type="number" 
                                                name="objectifs[{{ $employe->id }}][cible_personnelle]" 
                                                value="{{ old('objectifs.' . $employe->id . '.cible_personnelle', $tempData[$employe->id]['cible_personnelle'] ?? '') }}"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                                required min="0" step="0.01" placeholder="Ex: 30">
                                        </div>
                                        <input type="hidden" name="objectifs[{{ $employe->id }}][user_id]" value="{{ $employe->id }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination Tailwind stylisée -->
                        <div class="mt-12 flex justify-center">
                            {{ $employes->links() }}
                        </div>
                    @endif

                    <!-- Bouton submit (toujours visible) -->
                    <div class="mt-12 text-center">
                        <button type="submit" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xl font-bold rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-2xl">
                            <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Assigner les objectifs individuels
                        </button>
                    </div>
                </form>

                <!-- Retour -->
                <div class="mt-8 text-center">
                    <a href="{{ route('chef.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                        ← Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection