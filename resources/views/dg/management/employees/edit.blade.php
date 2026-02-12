@extends('layouts.main')

@section('title', 'Modifier l’Employé')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
            Modifier l’Employé : {{ $employee->name }}
        </h1>

        <div class="bg-white rounded-2xl shadow-xl p-10">
            <form action="{{ route('dg.employees.partialUpdate', $employee) }}" method="POST">
                @csrf
                @method('PATCH')  <!-- Important : PATCH pour update partiel -->

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Service -->
                    <div class="md:col-span-2">
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Affecter l'employé a un service *</label>
                        <select name="service_id" id="service_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un service</option>
                            @foreach($services as $id => $nom)
                                <option value="{{ $id }}" {{ old('service_id', $employee->service_id) == $id ? 'selected' : '' }}>
                                    {{ $nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Infos -->
                <div class="mt-8 bg-gray-50 p-6 rounded-xl">
                    <p class="text-sm text-gray-600">
                        <strong>Note :</strong> Le mot de passe est géré par l'employé lui-même via son profil.
                        Le chef est automatiquement assigné en fonction du service choisi.
                    </p>
                </div>

                <!-- Boutons -->
                <div class="mt-10 flex justify-end space-x-4">
                    <a href="{{ route('dg.employees.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection