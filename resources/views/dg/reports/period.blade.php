@extends('layouts.main')

@section('title', 'Rapports - ' . $periode->libelle)

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Titre + période -->
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4 text-center">
            Rapports de la période
        </h1>
        <p class="text-2xl font-bold text-indigo-600 mb-2 text-center">
            {{ $periode->libelle }}
        </p>
        <p class="text-lg text-gray-600 mb-12 text-center">
            Du {{ $periode->date_debut->format('d/m/Y') }} au {{ $periode->date_fin->format('d/m/Y') }}
        </p>

        <!-- Bouton PDF consolidé -->
        <div class="flex justify-center mb-16">
            <a href="{{ route('dg.reports.pdf.consolide', $periode) }}" 
               class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-xl font-bold rounded-2xl shadow-xl hover:from-green-700 hover:to-emerald-700 transition transform hover:scale-105 hover:shadow-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Générer le PDF Consolidé
            </a>
        </div>

        <!-- Contenu principal -->
        @if($rapportsByService->isEmpty())
            <div class="bg-gray-50 rounded-3xl p-12 text-center">
                <p class="text-2xl text-gray-600 font-medium">
                    Aucun rapport soumis pour cette période.
                </p>
            </div>
        @else
            <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">
                Rapports par service
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($rapportsByService as $serviceName => $rapports)
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden hover:shadow-3xl transition transform hover:-translate-y-2 duration-300">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6 text-white">
                            <h3 class="text-2xl font-bold">{{ $serviceName }}</h3>
                            <p class="text-indigo-100 mt-2">
                                {{ $rapports->count() }} rapport(s) soumis
                            </p>
                        </div>

                        <div class="p-8">
                            <a href="{{ route('dg.reports.service', [$periode, $rapports->first()->user->service]) }}" 
                               class="block w-full bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold text-center hover:bg-indigo-700 transition">
                                Voir les rapports de ce service
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Retour -->
        <div class="mt-16 text-center">
            <a href="{{ route('dg.reports.index') }}" 
               class="text-indigo-600 hover:text-indigo-800 font-medium text-xl inline-flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Retour à la liste des périodes
            </a>
        </div>
    </div>
</div>
@endsection