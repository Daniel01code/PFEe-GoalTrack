<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Liste des services actifs
     */
    public function index()
    {
        $services = Service::query()
            ->where('is_deleted', false)
            ->withCount(['employes' => function ($query) {
                $query->where('is_deleted', false);
            }])
            ->with('chef')
            ->latest()
            ->get();

        return view('dg.management.services.index', compact('services'));
    }

    /**
     * Formulaire création
     */
    public function create()
    {
        return view('dg.management.services.create');
    }

    /**
     * Enregistrer un nouveau service
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:services,nom',
            'description' => 'nullable|string',
        ]);

        $service = Service::create($validated);

        return redirect()
            ->route('dg.services.index')
            ->with('success', 'Service créé avec succès');
    }

    /**
     * Détails d’un service
     */
    public function show(Service $service)
    {
        abort_if($service->is_deleted, 404);

        $service->load([
            'chef',
            'employes' => function ($query) {
                $query->where('is_deleted', false);
            },
            'objectifsGlobaux'
        ]);

        return view('dg.management.services.show', compact('service'));
    }

    /**
     * Formulaire modification
     */
    public function edit(Service $service)
    {
        abort_if($service->is_deleted, 404);

        return view('dg.management.services.edit', compact('service'));
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, Service $service)
    {
        abort_if($service->is_deleted, 404);

        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:services,nom,' . $service->id,
            'description' => 'nullable|string',
        ]);

        $service->update($validated);

        return redirect()
            ->route('dg.services.index')
            ->with('success', 'Service modifié avec succès');
    }

    /**
     * Suppression logique (soft delete manuel)
     */
    public function destroy(Service $service)
    {
        if (
            $service->employes()->where('is_deleted', false)->exists() ||
            $service->objectifsGlobaux()->exists()
        ) {
            return back()->with(
                'error',
                'Impossible de supprimer : des employés ou objectifs sont liés à ce service.'
            );
        }

        $service->update(['is_deleted' => true]);

        return redirect()
            ->route('dg.services.index')
            ->with('success', 'Service supprimé avec succès');
    }
}
