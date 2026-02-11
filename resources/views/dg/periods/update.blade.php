@extends('layouts.main')

@section('title', 'Modifier la période en cours')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10">
                <h1 class="text-4xl font-bold text-white text-center">Modifier la période en cours</h1>
                @if($periodeEnCours)
                    <div class="mt-4 bg-yellow-100 border border-yellow-400 text-yellow-800 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                        Vous modifiez la période actuelle : "{{ $periodeEnCours->libelle }}"
                    </div>
                @endif
            </div>

            <div class="p-10">
                <form action="{{ route('dg.updatePeriode', $periodeEnCours->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                            <input type="date" name="date_debut" value="{{ $periodeEnCours->date_debut->format('Y-m-d') }}"
                                   class="w-full px-4 py-2 border rounded-lg">
                            @error('date_debut')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                            <input type="date" name="date_fin" value="{{ $periodeEnCours->date_fin->format('Y-m-d') }}"
                                   class="w-full px-4 py-2 border rounded-lg">
                            @error('date_fin')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700">
                            Mettre à jour la période
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('dg.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                        ← Retour au dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
