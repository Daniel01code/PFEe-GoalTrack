@extends('layouts.main')

@section('title', 'Démarrer Nouvelle Période')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                <h1 class="text-4xl font-bold text-white text-center">Démarrer une nouvelle période</h1>
                @if($periodeEnCours ?? false)
                    <div class="mb-8 bg-red-100 border border-red-400 text-red-800 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                        Attention : Démarrer une nouvelle période clôturera automatiquement la période actuelle "{{ $periodeEnCours->libelle }}".
                    </div>
                @endif
                <p class="mt-4 text-indigo-100 text-center text-lg">
                    Lancez le cycle hebdomadaire pour définir les objectifs de l'entreprise
                </p>
            </div>

            <div class="p-10">
                <div class="bg-indigo-50 rounded-2xl p-8 mb-8 text-center">
                    <p class="text-indigo-800 font-semibold text-xl">Période proposée automatiquement</p>
                    <p class="text-4xl font-bold text-indigo-600 mt-4">
                        Semaine {{ now()->weekOfYear }} - {{ now()->year }}
                    </p>
                    <p class="text-gray-700 mt-2 text-lg">
                        Du {{ now()->startOfWeek()->format('d/m/Y') }} au {{ now()->endOfWeek()->format('d/m/Y') }}
                    </p>
                </div>

                <form action="{{ route('periods.store') }}" method="POST">
                    @csrf

                    <div class="text-center">
                        <button type="submit" class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xl font-bold rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-xl">
                            <svg class="w-8 h-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Confirmer et démarrer la période
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