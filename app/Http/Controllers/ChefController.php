<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjectifGlobal;
use App\Models\ObjectifIndividuel;
use App\Models\Periode;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Validation;
use App\Models\Rapport ;

class ChefController extends Controller
{
    public function dashboard()
    {
        $chef = Auth::user();
        $service = $chef->service;

        // Période en cours
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();

        // Objectifs globaux du service
        $objectifsGlobaux = [];
        if ($periodeEnCours && $service) {
            $objectifsGlobaux = ObjectifGlobal::where('periode_id', $periodeEnCours->id)
                ->where('service_id', $service->id)
                ->get();
        }

        return view('chef.dashboard', compact('periodeEnCours', 'objectifsGlobaux'));
    }

    public function createIndividualGoal($objectifGlobalId)
    {
        $objectifGlobal = ObjectifGlobal::findOrFail($objectifGlobalId);

        if (Auth::user()->service_id !== $objectifGlobal->service_id) {
            abort(403);
        }

        $employes = User::where('service_id', $objectifGlobal->service_id)
            ->where('role', 'employe')
            ->paginate(10);

        // Récupère les données temporaires de la session pour pré-remplir
        $tempData = session()->get("declinaison.temp.{$objectifGlobal->id}", []);

        return view('chef.individual-goals.create', compact('objectifGlobal', 'employes', 'tempData'));
    }

    public function storeIndividualGoal(Request $request, $objectifGlobalId)
    {

        $objectifGlobal = ObjectifGlobal::findOrFail($objectifGlobalId);

        // Validation
        $request->validate([
            'objectifs.*.cible_personnelle' => 'required|numeric|min:0',
            'objectifs.*.user_id' => 'required|exists:users,id',
        ]);

        foreach ($request->objectifs as $data) {
            ObjectifIndividuel::updateOrCreate(
                [
                    'objectif_global_id' => $objectifGlobal->id,
                    'user_id' => $data['user_id'],
                ],
                [
                    'cible_personnelle' => $data['cible_personnelle'],
                    'pourcentage_atteinte' => 0,
                    'statut' => 'assigne',
                ]
            );
        }

        return redirect('/chef/dashboard')->with('success', 'Objectifs individuels assignés avec succès !');
    }
    public function indexReports()
    {
        $chef = Auth::user();
        $service = $chef->service;

        // Récupérer la période en cours (ou null si aucune)
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();

        // Initialiser une collection vide
        $rapports = collect();

        // Si période en cours ET service existe
        if ($periodeEnCours && $service) {
            $rapports = Rapport::query()
                ->whereHas('user', function ($query) use ($service) {
                    $query->where('service_id', $service->id);
                })
                ->where('periode_id', $periodeEnCours->id)
                ->where('statut', 'soumis')
                ->with(['user' => function ($query) {
                    $query->select('id', 'name', 'service_id');
                }])
                ->orderBy('date_soumission', 'desc')
                ->paginate(10); // Pagination 10 par page
        }

        return view('chef.reports.index', compact('periodeEnCours', 'rapports'));
    }

    public function validateReport(Request $request, Rapport $rapport)
    {
        // Vérifie que le rapport appartient à un employé de son service
        if ($rapport->user->service_id !== Auth::user()->service_id) {
            abort(403);
        }

        $request->validate([
            'commentaire' => 'nullable|string|max:500',
        ]);

        $rapport->update([
            'statut' => 'valide',
        ]);

        Validation::create([
            'rapport_id' => $rapport->id,
            'valideur_id' => Auth::id(),
            'commentaire' => $request->commentaire,
            'statut' => 'valide',
            'date_validation' => now(),
        ]);
        

        return redirect()->route('reports.index')->with('success', 'Rapport validé avec succès !');
    }

    public function rejectReport(Request $request, Rapport $rapport)
    {
        // Même vérification
        if ($rapport->user->service_id !== Auth::user()->service_id) {
            abort(403);
        }

        $request->validate([
            'commentaire' => 'required|string|max:500',
        ]);

        $rapport->update([
            'statut' => 'rejete',
        ]);

        Validation::create([
            'rapport_id' => $rapport->id,
            'valideur_id' => Auth::id(),
            'commentaire' => $request->commentaire,
            'statut' => 'rejete',
            'date_validation' => now(),
        ]);

        return redirect()->route('reports.index')->with('success', 'Rapport rejeté avec commentaire.');
    }

        public function reportsIndex()
    {
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();
        $periodesCloturees = Periode::where('statut', 'cloturee')->orderBy('date_fin', 'desc')->get();

        return view('dg.reports.index', compact('periodeEnCours', 'periodesCloturees'));
    }

    public function reportsByPeriod(Periode $periode)
    {
        $rapports = Rapport::where('periode_id', $periode->id)
            ->with(['user.service', 'user.chef'])
            ->orderBy('date_soumission', 'desc')
            ->get()
            ->groupBy('user.service.nom');

        return view('dg.reports.period', compact('periode', 'rapports'));
    }
    
}
