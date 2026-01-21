<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ObjectifIndividuel;
use App\Models\Rapport;
use App\Models\Periode;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Période en cours
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();

        // Objectifs individuels de l'utilisateur pour la période en cours
        $objectifs = [];
        if ($periodeEnCours) {
            $objectifs = ObjectifIndividuel::where('user_id', $user->id)
                ->whereHas('objectifGlobal', function ($query) use ($periodeEnCours) {
                    $query->where('periode_id', $periodeEnCours->id);
                })
                ->get();
        }

        return view('employee.dashboard', compact('periodeEnCours', 'objectifs'));
    }

    public function createReport()
    {
        $user = Auth::user();
        $periodeEnCours = Periode::where('statut', 'en_cours')->first();

        if (!$periodeEnCours) {
            return redirect()->route('employee.dashboard')->with('error', 'Aucune période en cours.');
        }

        // Vérifie si un rapport existe déjà pour cette période (brouillon ou soumis)
        $rapportExistant = Rapport::where('user_id', $user->id)
            ->where('periode_id', $periodeEnCours->id)
            ->first();

        return view('employee.reports.create', compact('periodeEnCours', 'rapportExistant'));
    }
    public function storeReport(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $periodeEnCours = Periode::where('statut', 'en_cours')->firstOrFail();

        $request->validate([
            'realisations' => 'required|string',
            'difficultes' => 'nullable|string',
            'pourcentage_atteinte' => 'nullable|numeric|min:0|max:100',
        ]);

        $rapport = Rapport::updateOrCreate(
            [
                'user_id' => $user->id,
                'periode_id' => $periodeEnCours->id,
            ],
            [
                'statut' => 'soumis',
                'contenu' => json_encode([
                    'realisations' => $request->realisations,
                    'difficultes' => $request->difficultes,
                ]),
                'pourcentage_atteinte' => $request->pourcentage_atteinte,
                'date_soumission' => now(),
            ]
        );
        // dd($rapport);

        return redirect()->route('employee.dashboard')->with('success', 'Rapport soumis avec succès !');
    }
}
