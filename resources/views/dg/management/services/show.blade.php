@extends('layouts.main')

@section('title', 'Détails du Service')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Service : {{ $service->nom }}</h1>
            <div class="space-x-4">
                <a href="{{ route('dg.services.edit', $service) }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    Modifier
                </a>
                <form action="{{ route('dg.services.destroy', $service) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700 transition" onclick="return confirm('Voulez-vous vraiment supprimer ce service ?')">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-10 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="text-lg"><strong>Matricule :</strong> {{ $service->matricule ?? 'Non généré' }}</p>
                    <p class="text-lg mt-4"><strong>Description :</strong> {{ $service->description ?? 'Aucune description' }}</p>
                </div>
                <div>
                    <p class="text-lg"><strong>Chef actuel :</strong> {{ $service->chef->name ?? 'Aucun chef assigné' }}</p>
                    <p class="text-lg mt-4"><strong>Nombre d'employés actifs :</strong> {{ $service->employes->count() }}</p>
                    <p class="text-lg mt-4"><strong>Objectifs globaux publiés :</strong> {{ $service->objectifsGlobaux->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Liste des employés -->
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Employés du service</h2>
        @if($service->employes->isEmpty())
            <p class="text-gray-600 text-center text-xl">Aucun employé dans ce service pour le moment.</p>
        @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nom</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Matricule</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($service->employes as $employe)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $employe->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employe->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employe->matricule ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-12 text-center">
            <a href="{{ route('dg.services.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-lg">
                ← Retour à la liste des services
            </a>
        </div>
    </div>
</div>
@endsection