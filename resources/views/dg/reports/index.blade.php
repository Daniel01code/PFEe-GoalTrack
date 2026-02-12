@extends('layouts.main')

@section('title', 'Gestion des Rapports - DG')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-12 text-center">
            Gestion des Rapports
        </h1>

        
        <!-- Période en cours -->
        @if($periodeEnCours)
            <div class="relative bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl shadow-2xl p-10 mb-16 text-white text-center overflow-hidden">
                <!-- Décorations circulaires -->
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -bottom-10 -right-10 w-56 h-56 bg-white opacity-10 rounded-full"></div>
                <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-5 rounded-full"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white opacity-5 rounded-full"></div>

                <!-- Texte -->
                <h2 class="text-4xl font-extrabold mb-4">{{ $periodeEnCours->libelle }}</h2>
                <p class="text-xl mb-8">
                    Du <span class="font-medium">{{ $periodeEnCours->date_debut->format('d/m/Y') }}</span> 
                    au <span class="font-medium">{{ $periodeEnCours->date_fin->format('d/m/Y') }}</span>
                </p>

                <!-- Boutons -->
                <div class="flex flex-col md:flex-row justify-center gap-6">
                    <a href="{{ route('dg.reports.period', $periodeEnCours) }}" 
                    class="inline-flex items-center justify-center px-10 py-5 bg-white text-indigo-700 font-bold text-lg rounded-2xl shadow-lg hover:bg-gray-100 transform hover:scale-105 transition">
                        Voir les rapports
                    </a>
                    <a href="{{ route('dg.reports.pdf.consolide', $periodeEnCours) }}" 
                    class="inline-flex items-center justify-center px-10 py-5 bg-green-600 text-white font-bold text-lg rounded-2xl shadow-lg hover:bg-green-700 transform hover:scale-105 transition">
                        <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF Consolidé
                    </a>
                </div>
            </div>
        @endif


        <!-- Périodes clôturées -->
        @if($periodesCloturees->count() > 0)
            <h2 class="text-3xl font-bold text-gray-900 mb-10 text-center">Périodes clôturées</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($periodesCloturees as $periode)
                    <div class="bg-white rounded-3xl shadow-2xl p-8 hover:shadow-3xl transition transform hover:-translate-y-2">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $periode->libelle }}</h3>
                        <p class="text-gray-600 mb-6">
                            Du {{ $periode->date_debut->format('d/m/Y') }} au {{ $periode->date_fin->format('d/m/Y') }}
                        </p>
                        <div class="flex flex-col space-y-4">
                            <a href="{{ route('dg.reports.period', $periode) }}" class="bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-700 transition text-center">
                                Voir les rapports
                            </a>
                            <a href="{{ route('dg.reports.pdf.consolide', $periode) }}" class="bg-green-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 transition flex items-center justify-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                PDF Consolidé
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600 text-xl">Aucune période clôturée disponible.</p>
        @endif
    </div>
</div>
@endsection