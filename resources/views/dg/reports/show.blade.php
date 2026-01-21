@extends('layouts.main')

@section('title', 'Détail du Rapport')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10 text-white">
                <h1 class="text-4xl font-bold text-center">Détail du Rapport</h1>
            </div>

            <div class="p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <!-- Infos employé & hiérarchie -->
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Employé</h2>
                        <p class="text-lg"><strong>Nom :</strong> {{ $rapport->user->name }}</p>
                        <p class="text-lg"><strong>Email :</strong> {{ $rapport->user->email }}</p>
                        <p class="text-lg"><strong>Service :</strong> {{ $rapport->user->service->nom ?? 'Non défini' }}</p>
                        <p class="text-lg"><strong>Chef :</strong> {{ $rapport->user->chef->name ?? 'Non défini' }}</p>
                    </div>

                    <!-- Infos période & statut -->
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Période & Statut</h2>
                        <p class="text-lg"><strong>Période :</strong> {{ $rapport->periode->libelle }}</p>
                        <p class="text-lg"><strong>Soumis le :</strong> {{ $rapport->date_soumission?->format('d/m/Y à H:i') }}</p>
                        <p class="text-lg">
                            <strong>Statut :</strong> 
                            <span class="font-bold {{ $rapport->statut == 'valide' ? 'text-green-600' : ($rapport->statut == 'rejete' ? 'text-red-600' : 'text-yellow-600') }}">
                                {{ ucfirst($rapport->statut) }}
                            </span>
                        </p>
                        @if($rapport->validation)
                            <p class="text-lg mt-2">
                                <strong>Commentaire du chef :</strong> {{ $rapport->validation->commentaire ?? 'Aucun' }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Objectif assigné -->
                @if($objectifIndividuel = $rapport->user->objectifsIndividuels->where('objectif_global.periode_id', $rapport->periode_id)->first())
                    <div class="bg-indigo-50 rounded-2xl p-8 mb-10">
                        <h2 class="text-2xl font-bold text-indigo-800 mb-4">Objectif individuel assigné</h2>
                        <p class="text-xl font-semibold text-indigo-600">{{ $objectifIndividuel->objectifGlobal->description }}</p>
                        <p class="text-lg mt-2">
                            <strong>Cible personnelle :</strong> {{ $objectifIndividuel->cible_personnelle }} ({{ $objectifIndividuel->objectifGlobal->unite }})
                        </p>
                        <p class="text-lg">
                            <strong>Progression actuelle :</strong> {{ $objectifIndividuel->pourcentage_atteinte }}%
                        </p>
                    </div>

                    <div class="bg-purple-50 rounded-2xl p-8 mb-10">
                        <h2 class="text-2xl font-bold text-purple-800 mb-4">Objectif global associé (service)</h2>
                        <p class="text-xl font-semibold text-purple-600">{{ $objectifIndividuel->objectifGlobal->description }}</p>
                        <p class="text-lg mt-2">
                            <strong>Cible globale :</strong> {{ $objectifIndividuel->objectifGlobal->cible }} {{ $objectifIndividuel->objectifGlobal->unite }}
                        </p>
                        <p class="text-lg">
                            <strong>Service :</strong> {{ $objectifIndividuel->objectifGlobal->service->nom }}
                        </p>
                    </div>
                @else
                    <p class="text-center text-gray-600 text-xl mb-10">Aucun objectif individuel trouvé pour cette période.</p>
                @endif

                <!-- Contenu du rapport -->
                <div class="bg-gray-50 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Contenu du rapport</h2>
                    <p class="font-semibold mb-2 text-gray-800">Réalisations :</p>
                    <p class="text-gray-700 whitespace-pre-line mb-6">{{ $rapport->contenu['realisations'] ?? 'Non renseigné' }}</p>

                    <p class="font-semibold mb-2 text-gray-800">Difficultés rencontrées :</p>
                    <p class="text-gray-700 whitespace-pre-line">{{ $rapport->contenu['difficultes'] ?? 'Aucune mentionnée' }}</p>

                    @if($rapport->pourcentage_atteinte !== null)
                        <p class="font-semibold mt-6 text-gray-800 text-xl">
                            Pourcentage d'atteinte déclaré : {{ $rapport->pourcentage_atteinte }}%
                        </p>
                    @endif
                </div>

                <!-- Bouton PDF individuel -->
                <div class="mt-12 text-center">
                    <a href="{{ route('dg.reports.pdf.individual', $rapport) }}" class="inline-flex items-center px-12 py-5 bg-gradient-to-r from-red-600 to-pink-600 text-white text-xl font-bold rounded-2xl hover:from-red-700 hover:to-pink-700 transition transform hover:scale-105 shadow-2xl">
                        <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Générer PDF de ce rapport
                    </a>
                </div>

                <!-- Retour -->
                <div class="mt-8 text-center">
                    <a href="{{ url()->previous() }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                        ← Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection