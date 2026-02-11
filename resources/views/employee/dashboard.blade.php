@extends('layouts.main')

@section('title', 'Dashboard Employé')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
            Mon Dashboard - {{ auth()->user()->name }}
        </h1>

        @if(session('success'))
            <div class="mb-8 bg-green-100 border-l-4 border-green-500 text-green-700 p-6 rounded-r-lg">
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

        @if($periodeEnCours ?? false)
            <div class="bg-indigo-100 rounded-2xl p-6 mb-10 text-center">
                <p class="text-2xl font-bold text-indigo-800">
                    Période en cours : {{ $periodeEnCours->libelle }}
                </p>
            </div>
        @else
            <div class="bg-yellow-100 rounded-2xl p-6 mb-10 text-center">
                <p class="text-2xl font-bold text-yellow-800">
                    Aucune période en cours
                </p>
            </div>
        @endif

        <h2 class="text-3xl font-bold text-gray-900 mb-8">Mes objectifs individuels</h2>

        @if($objectifs->isEmpty())
            <p class="text-center text-gray-600 text-xl">
                Aucun objectif assigné pour cette période.
            </p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($objectifs as $objectif)

                    @php
                        $pourcentage = $objectif->pourcentage_atteinte;

                        if ($pourcentage >= 100) {
                            $statut = 'Atteint';
                            $badgeColor = 'bg-green-100 text-green-800';
                        } elseif ($pourcentage >= 50) {
                            $statut = 'En bonne progression';
                            $badgeColor = 'bg-blue-100 text-blue-800';
                        } elseif ($pourcentage > 0) {
                            $statut = 'En cours';
                            $badgeColor = 'bg-yellow-100 text-yellow-800';
                        } else {
                            $statut = 'Non démarré';
                            $badgeColor = 'bg-red-100 text-red-800';
                        }
                    @endphp

                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <h3 class="text-2xl font-bold text-indigo-600 mb-4">
                            {{ $objectif->objectifGlobal->description }}
                        </h3>

                        <p class="text-lg text-gray-700 mb-4">
                            <span class="font-semibold">Cible personnelle :</span>
                            {{ $objectif->cible_personnelle }} ({{ $objectif->objectifGlobal->unite }})
                        </p>

                        <p class="text-gray-600 mb-4">
                            <span class="font-semibold">Progression :</span>
                            {{ $pourcentage }}%
                        </p>

                        <!-- Barre de progression -->
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                            <div 
                                class="h-4 rounded-full bg-indigo-600"
                                style="width: {{ min($pourcentage, 100) }}%">
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="text-center mt-4">
                            <span class="px-4 py-2 text-sm font-bold rounded-full {{ $badgeColor }}">
                                Statut : {{ $statut }}
                            </span>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('reports.create') }}" 
               class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-green-600 to-teal-600 text-white text-xl font-bold rounded-2xl hover:from-green-700 hover:to-teal-700 transition transform hover:scale-105 shadow-2xl">
                <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 13h6m-6-6h6m-3 12h6m-6 0h-6">
                    </path>
                </svg>
                Remplir mon rapport hebdomadaire
            </a>
        </div>
    </div>
</div>
@endsection
