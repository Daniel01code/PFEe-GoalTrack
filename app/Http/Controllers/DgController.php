<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periode;
use App\Models\Service;
use App\Models\User;
use App\Models\Rapport;
use App\Models\ObjectifIndividuel;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\ObjectifGlobal;
use Barryvdh\DomPDF\Facade\Pdf;

class DgController extends Controller
{
    //methode du dashbord du dg

    //dashbord
    public function dashboard()
    {
        // Période en cours
        $periodeEnCours = Periode::where('statut', 'en_cours')->latest()->first();
        // dd($periodeEnCours);
        // Stats globales
        $totalServices = Service::count();
        $totalEmployes = User::where('role', 'employe')->count();
        $totalRapportsSoumis = Rapport::whereIn('statut', ['soumis', 'valide', 'rejete'])->count();

        // Taux d'atteinte global (moyenne des objectifs individuels de la période en cours)
        $tauxAtteinte = 0;
        if ($periodeEnCours) {
            $objectifs = ObjectifIndividuel::whereHas('objectifGlobal', function ($q) use ($periodeEnCours) {
                $q->where('periode_id', $periodeEnCours->id);
            })->avg('pourcentage_atteinte');

            $tauxAtteinte = round($objectifs ?? 0, 1);
        }

        return view('dg.dashboard', compact(
            'periodeEnCours',
            'totalServices',
            'totalEmployes',
            'totalRapportsSoumis',
            'tauxAtteinte'
        ));
    }
    // vue creer une periode
    public function createPeriod()
    {
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();

        return view('dg.periods.create', compact('periodeEnCours'));
    }
    // vue editer la periode en cour
    public function editPeriode()
    {
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();
        return view('dg.periods.update', compact('periodeEnCours'));
    }
     // editer la periode en cour
    public function updatePeriode(Request $request, Periode $periode)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        $periode->update([
            'date_debut' => Carbon::parse($request->date_debut),
            'date_fin' => Carbon::parse($request->date_fin),
            'libelle' => 'Semaine ' . Carbon::parse($request->date_debut)->weekOfYear . ' - ' . Carbon::parse($request->date_debut)->year,
        ]);

        return redirect()->route('dg.dashboard')->with('success', 'Période mise à jour avec succès !');
    }

    public function storePeriod(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after:date_debut',
        ]);

        // Clôturer l'ancienne période si elle existe
        Periode::where('statut', 'en_cours')->update(['statut' => 'cloturee']);

        $start = Carbon::parse($request->date_debut);
        $end   = Carbon::parse($request->date_fin);

        Periode::create([
            'libelle'     => 'Période du ' . $start->format('d/m/Y') . ' au ' . $end->format('d/m/Y'),
            'date_debut'  => $start,
            'date_fin'    => $end,
            'statut'      => 'en_cours',
        ]);

        return redirect()
            ->route('dg.dashboard')
            ->with('success', 'Nouvelle période créée avec succès !');
    }




    //createGlobalGoal
    public function createGlobalGoal()
    {
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();

        if (!$periodeEnCours) {
            return redirect()->route('dg.dashboard')->with('error', 'Aucune période en cours. Démarrez une période d\'abord.');
        }

        $services = Service::all();

        return view('dg.global-goals.create', compact('periodeEnCours', 'services'));
    }

    public function storeGlobalGoal(Request $request)
    {
        $periodeEnCours = Periode::where('statut', 'en_cours')->firstOrFail();

        $request->validate([
            'objectifs.*.description' => 'required|string|max:255',
            'objectifs.*.cible' => 'required|numeric|min:0',
            'objectifs.*.unite' => 'required|string|max:50',
            'objectifs.*.service_id' => ['required', Rule::exists('services', 'id')],
        ]);

        foreach ($request->objectifs as $data) {
            ObjectifGlobal::create([
                'periode_id' => $periodeEnCours->id,
                'service_id' => $data['service_id'],
                'description' => $data['description'],
                'cible' => $data['cible'],
                'unite' => $data['unite'],
            ]);
        }

        return redirect()->route('dg.dashboard')->with('success', 'Objectifs stratégiques publiés avec succès !');
    }

    public function reportsIndex()
    {
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();
        $periodesCloturees = Periode::where('statut', 'cloturee')->orderBy('date_fin', 'desc')->get();

        return view('dg.reports.index', compact('periodeEnCours', 'periodesCloturees'));
    }

    public function reportsByPeriod(Periode $periode)
    {
        $rapportsByService = Rapport::where('periode_id', $periode->id)
            ->with(['user.service', 'user'])
            ->get()
            ->groupBy('user.service.nom');

        return view('dg.reports.period', compact('periode', 'rapportsByService'));
    }

    public function reportsByService(Periode $periode, Service $service)
    {
        $rapports = Rapport::where('periode_id', $periode->id)
            ->whereHas('user', function ($query) use ($service) {
                $query->where('service_id', $service->id);
            })
            ->with('user')
            ->orderBy('date_soumission', 'desc')
            ->paginate(10);  // ← ici la clé !

        return view('dg.reports.service', compact('periode', 'service', 'rapports'));
    }

    public function reportShow(Rapport $rapport)
    {
        $rapport->load(['user.service', 'user.chef', 'periode', 'validation']);

        return view('dg.reports.show', compact('rapport'));
    }

    public function pdfConsolide(Periode $periode)
    {
        $objectifsGlobaux = ObjectifGlobal::where('periode_id', $periode->id)->with('service')->get();

        $tauxAtteinte = ObjectifIndividuel::whereHas('objectifGlobal', fn($q) => $q->where('periode_id', $periode->id))
            ->avg('pourcentage_atteinte');

        $tauxAtteinte = round($tauxAtteinte ?? 0, 1);

        $rapportsValides = Rapport::where('periode_id', $periode->id)
            ->where('statut', 'valide')
            ->count();

        $pdf = PDF::loadView('dg.reports.pdf-consolide', compact('periode', 'objectifsGlobaux', 'tauxAtteinte', 'rapportsValides'));

        return $pdf->download('rapport_consolide_' . str_replace(' ', '_', $periode->libelle) . '.pdf');
    }

    public function pdfIndividual(Rapport $rapport)
    {
        $rapport->load(['user.service', 'user.chef', 'periode', 'validation']);

        $pdf = PDF::loadView('dg.reports.pdf-individual', compact('rapport'));

        return $pdf->download('rapport_' . $rapport->user->name . '_' . $rapport->periode->libelle . '.pdf');
    }
}
