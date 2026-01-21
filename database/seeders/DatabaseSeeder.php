<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Periode;
use App\Models\ObjectifGlobal;
use App\Models\ObjectifIndividuel;
use App\Models\Rapport;
use App\Models\Validation;
use App\Models\Journalisation;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer 8 services
        $services = Service::factory()->count(8)->create();

        // 2. Créer le DG
        User::updateOrCreate(
            ['email' => 'dg@entreprise.cm'],
            [
                'name' => 'Directeur Général',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role' => 'dg',
            ]
        );

        // 3. Créer 8 chefs (1 par service)
        $chefs = [];
        foreach ($services as $service) {
            $chef = User::updateOrCreate(
                ['email' => 'chef.' . strtolower(str_replace(' ', '.', $service->nom)) . '@entreprise.cm'],
                [
                    'name' => 'Chef du service ' . $service->nom,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'role' => 'chef',
                    'service_id' => $service->id,
                ]
            );
            $chefs[$service->id] = $chef->id; // Index par service_id pour récupération rapide
        }

        // 4. Créer 80 employés, affectés aléatoirement à un service + chef correspondant
        for ($i = 1; $i <= 80; $i++) {
            $service = $services->random(); // Service aléatoire
            $chefId = $chefs[$service->id]; // Chef du service choisi

            User::create([
                'name' => 'Employé ' . $i,
                'email' => 'employe' . $i . '@entreprise.cm',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'role' => 'employe',
                'service_id' => $service->id,
                'chef_id' => $chefId,
            ]);
        }

        // 5. Créer 9 périodes clôturées + 1 en cours
        for ($i = 1; $i <= 9; $i++) {
            Periode::create([
                'libelle' => "Semaine $i - 2025",
                'date_debut' => Carbon::now()->subWeeks(10 - $i)->startOfWeek(),
                'date_fin' => Carbon::now()->subWeeks(10 - $i)->endOfWeek(),
                'statut' => 'cloturee',
            ]);
        }

        Periode::create([
            'libelle' => 'Semaine en cours',
            'date_debut' => Carbon::now()->startOfWeek(),
            'date_fin' => Carbon::now()->endOfWeek(),
            'statut' => 'en_cours',
        ]);

        // 6. Objectifs globaux + individuels (inchangé)
        $periodes = Periode::all();
        foreach ($periodes as $periode) {
            foreach ($services as $service) {
                $global = ObjectifGlobal::create([
                    'periode_id' => $periode->id,
                    'service_id' => $service->id,
                    'description' => "Objectif stratégique {$service->nom} - {$periode->libelle}",
                    'cible' => fake()->numberBetween(200, 1000),
                    'unite' => fake()->randomElement(['contrats', 'clients', 'CA FCFA', 'projets', 'visites']),
                ]);

                $employesDuService = User::where('service_id', $service->id)->where('role', 'employe')->get();
                foreach ($employesDuService as $employe) {
                    $statutIndividuel = $periode->statut === 'cloturee' 
                        ? fake()->randomElement(['atteint', 'partiel', 'assigne'])
                        : 'assigne';

                    ObjectifIndividuel::create([
                        'objectif_global_id' => $global->id,
                        'user_id' => $employe->id,
                        'cible_personnelle' => fake()->numberBetween(20, 100),
                        'pourcentage_atteinte' => $periode->statut === 'cloturee' ? fake()->numberBetween(0, 100) : 0,
                        'commentaire' => fake()->optional(0.7)->paragraph(),
                        'statut' => $statutIndividuel,
                    ]);
                }
            }
        }

        // 7. Rapports + validations (inchangé)
        $periodesCloturees = Periode::where('statut', 'cloturee')->get();
        foreach ($periodesCloturees as $periode) {
            $employes = User::where('role', 'employe')->get();
            foreach ($employes as $employe) {
                $statutRapport = fake()->randomElement(['brouillon', 'soumis', 'valide', 'rejete']);

                $rapport = Rapport::create([
                    'user_id' => $employe->id,
                    'periode_id' => $periode->id,
                    'statut' => $statutRapport,
                    'contenu' => json_encode([
                        'realisations' => fake()->paragraphs(2, true),
                        'difficultes' => fake()->optional()->paragraph(),
                    ]),
                    'date_soumission' => in_array($statutRapport, ['soumis', 'valide', 'rejete']) 
                        ? fake()->dateTimeBetween($periode->date_debut, $periode->date_fin) 
                        : null,
                ]);

                if (in_array($rapport->statut, ['valide', 'rejete']) && $employe->chef_id) {
                    Validation::create([
                        'rapport_id' => $rapport->id,
                        'valideur_id' => $employe->chef_id,
                        'commentaire' => fake()->optional()->paragraph(),
                        'statut' => $rapport->statut,
                        'date_validation' => fake()->dateTimeBetween($rapport->date_soumission, now()),
                    ]);
                }
            }
        }

        // 8. Logs
        Journalisation::factory(500)->create();
    }
}