@extends('layouts.main')

@section('title', 'Modifier le Service')

@section('content')
<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">Modifier le Service : {{ $service->nom }}</h1>

        <div class="bg-white rounded-2xl shadow-xl p-10">
            <form action="{{ route('dg.services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du service *</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom', $service->nom) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('dg.services.index') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition">
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