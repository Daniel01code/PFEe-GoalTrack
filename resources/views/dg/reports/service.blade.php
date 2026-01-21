@extends('layouts.main')

@section('title', 'Rapports - ' . $service->nom)

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
            Rapports du service : {{ $service->nom }}
        </h1>

        <p class="text-xl text-gray-700 mb-12 text-center">
            Période : {{ $periode->libelle }} ({{ $rapports->count() }} rapport(s))
        </p>

        @if($rapports->isEmpty())
            <p class="text-center text-gray-600 text-xl">Aucun rapport soumis pour ce service dans cette période.</p>
        @else
            <div class="space-y-8">
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
                                {{ ucfirst($rapport->statut) }}
                            </span>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <p class="font-semibold mb-2 text-gray-800">Réalisations :</p>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rapport->contenu['realisations'] ?? 'Non renseigné' }}</p>

                            <p class="font-semibold mt-4 mb-2 text-gray-800">Difficultés :</p>
                            <p class="text-gray-700 whitespace-pre-line">{{ $rapport->contenu['difficultes'] ?? 'Aucune' }}</p>
                        </div>

                        <div class="flex justify-center space-x-6">
                            <a href="{{ route('dg.reports.show', $rapport) }}" class="inline-flex items-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition">
                                Voir le détail
                            </a>
                            <a href="{{ route('dg.reports.pdf.individual', $rapport) }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                PDF
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $rapports->links('vendor.pagination.tailwind') }}
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('dg.reports.period', $periode) }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg mr-8">
                ← Retour à la période
            </a>
            <a href="{{ route('dg.reports.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                ← Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection