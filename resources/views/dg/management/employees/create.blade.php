@extends('layouts.main')

@section('title', 'Créer un Employé')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Créer un Nouvel Employé</h1>

        <div class="bg-white rounded-2xl shadow-xl p-10">
            <form action="{{ route('dg.employees.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe *</label>
                        <input type="password" name="password" id="password" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700 mb-2">Service *</label>
                        <select name="service_id" id="service_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un service</option>
                            @foreach($services as $id => $nom)
                                <option value="{{ $id }}" {{ old('service_id') == $id ? 'selected' : '' }}>{{ $nom }}</option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="chef_id" class="block text-sm font-medium text-gray-700 mb-2">Chef direct (optionnel)</label>
                        <select name="chef_id" id="chef_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Aucun chef</option>
                            <!-- À remplir dynamiquement via JS ou passer les chefs depuis le controller -->
                        </select>
                    </div>
                </div>

                <div class="mt-10 flex justify-end space-x-4">
                    <a href="{{ route('dg.employees.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                        Créer l’Employé
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection