@extends('layouts.main')

@section('title', 'Détails de l’Employé')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Employé : {{ $employee->name }}</h1>
            <div class="space-x-4">
                <a href="{{ route('dg.employees.edit', $employee) }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    Modifier
                </a>
                <form action="{{ route('dg.employees.destroy', $employee) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition" onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?')">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-10 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="text-lg"><strong>Matricule :</strong> {{ $employee->matricule ?? 'Non généré' }}</p>
                    <p class="text-lg mt-4"><strong>Email :</strong> {{ $employee->email }}</p>
                    <p class="text-lg mt-4"><strong>Service :</strong> {{ $employee->service->nom ?? 'Non assigné' }}</p>
                    <p class="text-lg mt-4"><strong>Chef direct :</strong> {{ $employee->chef->name ?? 'Aucun' }}</p>
                </div>
                <div>
                    <p class="text-lg"><strong>Objectifs individuels :</strong> {{ $employee->objectifsIndividuels->count() }}</p>
                    <p class="text-lg mt-4"><strong>Rapports soumis :</strong> {{ $employee->rapports->count() }}</p>
                    <p class="text-lg mt-4"><strong>Taux d’atteinte moyen :</strong> {{ number_format($employee->objectifsIndividuels->avg('pourcentage_atteinte') ?? 0, 1) }}%</p>
                </div>
            </div>
        </div>

        <!-- Liste des objectifs -->
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Objectifs individuels</h2>
        @if($employee->objectifsIndividuels->isEmpty())
            <p class="text-gray-600 text-center text-xl">Aucun objectif assigné pour le moment.</p>
        @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Objectif</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Période</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Cible</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Progression</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($employee->objectifsIndividuels as $objectif)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $objectif->objectifGlobal->description }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $objectif->objectifGlobal->periode->libelle }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $objectif->cible_personnelle }} {{ $objectif->objectifGlobal->unite }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $objectif->pourcentage_atteinte }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Liste des rapports -->
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Rapports soumis</h2>
        @if($employee->rapports->isEmpty())
            <p class="text-gray-600 text-center text-xl">Aucun rapport soumis pour le moment.</p>
        @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Période</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Statut</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Date soumission</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($employee->rapports as $rapport)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $rapport->periode->libelle }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $rapport->statut == 'valide' ? 'bg-green-100 text-green-800' : ($rapport->statut == 'rejete' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($rapport->statut) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $rapport->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('dg.employees.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                ← Retour à la liste des employés
            </a>
        </div>
    </div>
</div>
@endsection