<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeManagementController extends Controller
{
    // Liste des employés actifs
    public function index(Request $request)
    {
        $query = User::where('role', 'employe')
                     ->where('is_deleted', false);

        // Recherche
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('matricule', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre service
        if ($serviceId = $request->get('service_id')) {
            $query->where('service_id', $serviceId);
        }

        $employees = $query->with('service', 'chef')
                           ->latest()
                           ->paginate(15);

        // ⚠ nécessite le scopeActive dans Service
        $services = Service::active()->pluck('nom', 'id');

        return view('dg.management.employees.index', compact('employees', 'services'));
    }

    public function create()
    {
        $services = Service::active()->pluck('nom', 'id');
        return view('dg.management.employees.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'service_id' => 'required|exists:services,id',
            'chef_id' => 'nullable|exists:users,id',
        ]);

        $validated['role'] = 'employe';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('dg.employees.index')
                         ->with('success', 'Employé créé avec succès');
    }

    public function show(User $employee)
    {
        if ($employee->role !== 'employe' || $employee->is_deleted) {
            abort(404);
        }

        $employee->load([
            'service',
            'chef',
            'objectifsIndividuels' => fn($q) => $q->with('objectifGlobal')
        ]);

        return view('dg.management.employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        if ($employee->role !== 'employe' || $employee->is_deleted) {
            abort(404);
        }

        $services = Service::active()->pluck('nom', 'id');

        return view('dg.management.employees.edit', compact('employee', 'services'));
    }

    public function update(Request $request, User $employee)
    {
        if ($employee->role !== 'employe' || $employee->is_deleted) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->id,
            'password' => 'nullable|string|min:8|confirmed',
            'service_id' => 'required|exists:services,id',
            'chef_id' => 'nullable|exists:users,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $employee->update($validated);

        return redirect()->route('dg.employees.index')
                         ->with('success', 'Employé modifié avec succès');
    }

    public function destroy(User $employee)
    {
        if ($employee->role !== 'employe' || $employee->is_deleted) {
            abort(404);
        }

        if ($employee->rapports()->exists() || $employee->objectifsIndividuels()->exists()) {
            return back()->with(
                'error',
                'Impossible de supprimer : cet employé a des rapports ou objectifs associés.'
            );
        }

        $employee->update(['is_deleted' => true]);

        return redirect()->route('dg.employees.index')
                         ->with('success', 'Employé supprimé avec succès');
    }
    public function partialUpdate(Request $request, User $employee)
    {
        if ($employee->role !== 'employe' || $employee->is_deleted) {
            abort(404);
        }

        $validated = $request->validate([
            'name'       => 'sometimes|string|max:255',
            'email'      => 'sometimes|email|unique:users,email,' . $employee->id,
            'service_id' => 'sometimes|exists:services,id',
            // Pas de password ici (l'employé le gère lui-même)
        ]);

        // Attribution automatique du chef si service changé
        if ($request->has('service_id')) {
            $service = Service::find($validated['service_id']);
            $chef = $service->chef;
            $validated['chef_id'] = $chef ? $chef->id : null;
        }

        $employee->update($validated);

        return redirect()->route('dg.employees.index')
                        ->with('success', 'Employé mis à jour avec succès');
    }
}
