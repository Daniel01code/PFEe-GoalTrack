@extends('layouts.main')

@section('title', 'Démarrer Nouvelle Période')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                <h1 class="text-4xl font-bold text-white text-center">
                    Créer une nouvelle période
                </h1>

                @if($periodeEnCours ?? false)
                    <div class="mt-6 bg-red-100 border border-red-400 text-red-800 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                        Attention : créer une nouvelle période clôturera automatiquement la période actuelle "{{ $periodeEnCours->libelle }}".
                    </div>
                @endif

                <p class="mt-4 text-indigo-100 text-center text-lg">
                    Définissez manuellement la date de début et la date de fin
                </p>
            </div>

            <div class="p-10">

                <form action="{{ route('periods.store') }}" method="POST">
                    @csrf

                    <!-- Date début -->
                    <div class="mb-6">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Date de début
                        </label>
                        <input type="date" name="date_debut"
                               value="{{ old('date_debut') }}"
                               class="w-full px-6 py-4 border rounded-2xl focus:ring-2 focus:ring-indigo-500"
                               required>
                        @error('date_debut')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date fin -->
                    <div class="mb-8">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">
                            Date de fin
                        </label>
                        <input type="date" name="date_fin"
                               value="{{ old('date_fin') }}"
                               class="w-full px-6 py-4 border rounded-2xl focus:ring-2 focus:ring-indigo-500"
                               required>
                        @error('date_fin')
                            <p class="text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit"
                                class="inline-flex items-center px-10 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xl font-bold rounded-2xl hover:from-indigo-700 hover:to-purple-700 transition transform hover:scale-105 shadow-xl">
                            Confirmer et démarrer la période
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('dg.dashboard') }}"
                       class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                        ← Retour au dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
