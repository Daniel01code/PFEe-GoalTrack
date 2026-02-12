@extends('layouts.main')

@section('title', 'Gestion des Services')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête avec boutons -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Gestion des Services</h1>
            <div class="flex space-x-4">
                <!-- Bouton Gestion des Employés (nouveau) -->
                <a href="{{ route('dg.employees.index') }}" class="bg-teal-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-teal-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM6 5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Gérer les Employés
                </a>

                <!-- Bouton Nouveau Service -->
                <a href="{{ route('dg.services.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                    + Nouveau Service
                </a>
            </div>
        </div>

        <!-- Barre de recherche -->
        <form method="GET" action="{{ route('dg.services.index') }}" class="mb-8">
            <div class="flex max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom ou matricule..." class="flex-1 px-4 py-3 border border-gray-300 rounded-l-xl focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-r-xl hover:bg-indigo-700 transition">
                    Rechercher
                </button>
            </div>
        </form>

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

        @if(session('info'))
            <div class="mb-8 bg-blue-100 border border-blue-400 text-blue-700 px-6 py-4 rounded-2xl text-center text-lg font-medium">
                {{ session('info') }}
            </div>
        @endif

        @if($services->isEmpty())
            <p class="text-center text-gray-600 text-xl">Aucun service trouvé.</p>
        @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Matricule</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nom</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Chef</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Employés</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($services as $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->matricule ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $service->nom }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($service->description, 50) ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->chef->name ?? 'Aucun' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $service->employes_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('dg.services.show', $service) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Voir</a>
                                    <a href="{{ route('dg.services.edit', $service) }}" class="text-blue-600 hover:text-blue-900 mr-3">Modifier</a>
                                    <form action="{{ route('dg.services.destroy', $service) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Voulez-vous vraiment désactiver ce service ?')">
                                            Désactiver
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('dg.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Retour au dashboard
            </a>
        </div>
    </div>
</div>
@endsection