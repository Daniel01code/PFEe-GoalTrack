@extends('layouts.main')

@section('title', 'Remplir mon rapport')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-teal-600 px-8 py-10">
                <h1 class="text-4xl font-bold text-white text-center">Remplir mon rapport</h1>
            </div>

            <div class="p-10">
                <p class="text-gray-700 text-lg mb-8 text-center">
                    Rapport pour la période : {{ $periodeEnCours->libelle }}
                </p>

                @if($rapportExistant ?? false)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8">
                        <p class="text-yellow-800 font-semibold">Rapport déjà soumis le {{ $rapportExistant->date_soumission?->format('d/m/Y H:i') }}</p>
                    </div>
                @endif

                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf

                    <div class="space-y-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Réalisations de la période
                            </label>
                            <textarea name="realisations" rows="6" 
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                      required placeholder="Décrivez ce que vous avez accompli...">{{ $rapportExistant->contenu['realisations'] ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Difficultés rencontrées
                            </label>
                            <textarea name="difficultes" rows="4" 
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                      placeholder="Décrivez les obstacles...">{{ $rapportExistant->contenu['difficultes'] ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pourcentage d'atteinte global
                            </label>
                            <input type="number" name="pourcentage_atteinte" 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                   min="0" max="100" step="0.01" value="{{ $rapportExistant->pourcentage_atteinte ?? '' }}">
                        </div>
                    </div>

                    <div class="mt-12 text-center">
                        <button type="submit" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-green-600 to-teal-600 text-white text-xl font-bold rounded-2xl hover:from-green-700 hover:to-teal-700 transition transform hover:scale-105 shadow-2xl">
                            Soumettre mon rapport
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('employee.dashboard') }}" class="text-green-600 hover:text-green-800 font-medium text-lg">
                        ← Retour au dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection