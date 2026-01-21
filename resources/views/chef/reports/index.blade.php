@extends('layouts.main')

@section('title', 'Validation des Rapports')

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

        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
            Validation des Rapports - {{ auth()->user()->service->nom ?? 'Service non défini' }}
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

        @if($rapports->isEmpty())
            <p class="text-center text-gray-600 text-xl">Aucun rapport soumis pour validation dans cette période.</p>
        @else
            <div class="grid grid-cols-1 gap-8">
                @foreach($rapports as $rapport)
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-indigo-600">
                                    Rapport de {{ $rapport->user->name }}
                                </h3>
                                <p class="text-gray-600 mt-1">
                                    Soumis le {{ $rapport->date_soumission?->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-medium">
                                En attente
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <p class="font-semibold mb-2 text-gray-800">Réalisations :</p>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rapport->contenu['realisations'] ?? 'Non renseigné' }}</p>

                            <p class="font-semibold mt-4 mb-2 text-gray-800">Difficultés rencontrées :</p>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rapport->contenu['difficultes'] ?? 'Aucune mentionnée' }}</p>
                        </div>

                        <div class="flex justify-center space-x-6">
                            <!-- Formulaire Valider -->
                            <form action="{{ route('reports.validate', $rapport->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="commentaire" value="Validé sans commentaire">
                                <button type="submit" class="inline-flex items-center px-8 py-4 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition transform hover:scale-105">
                                    Valider
                                </button>
                            </form>

                            <!-- Formulaire Rejeter (avec commentaire obligatoire) -->
                            <form action="{{ route('reports.reject', $rapport->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <div class="relative">
                                    <textarea name="commentaire" rows="3" 
                                              class="w-64 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                                              placeholder="Commentaire obligatoire pour rejet..." required></textarea>
                                    <button type="submit" class="mt-2 inline-flex items-center px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition transform hover:scale-105">
                                        Rejeter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Retour au dashboard -->
        <div class="mt-12 text-center">
            <a href="{{ route('chef.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                ← Retour au dashboard
            </a>
        </div>
    </div>
</div>
@endsection