@extends('layouts.main')

@section('title', 'Gestion des Employés')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Gestion des Employés</h1>
            <a href="{{ route('dg.employees.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition">
                + Nouvel Employé
            </a>
        </div>

        <!-- Recherche + filtre -->
        <form method="GET" action="{{ route('dg.employees.index') }}" class="mb-8 flex flex-wrap gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, matricule ou email..." class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
            <select name="service_id" class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Tous les services</option>
                @foreach($services as $id => $nom)
                    <option value="{{ $id }}" {{ request('service_id') == $id ? 'selected' : '' }}>{{ $nom }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                Filtrer
            </button>
        </form>

        @if($employees->isEmpty())
            <p class="text-center text-gray-600 text-xl">Aucun employé trouvé.</p>
        @else
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Matricule</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nom</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Service</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Chef</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($employees as $employee)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->matricule ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $employee->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->service->nom ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $employee->chef->name ?? 'Aucun' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('dg.employees.show', $employee) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Voir</a>
                                    <a href="{{ route('dg.employees.edit', $employee) }}" class="text-blue-600 hover:text-blue-900 mr-3">Modifier</a>
                                    <form action="{{ route('dg.employees.destroy', $employee) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Voulez-vous vraiment supprimer cet employé ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="px-6 py-4">
                    {{ $employees->links() }}
                </div>
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