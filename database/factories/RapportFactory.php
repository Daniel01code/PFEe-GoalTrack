<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Service;
use App\Models\Periode;
use App\Models\ObjectifGlobal;
use App\Models\ObjectifIndividuel;
use App\Models\Rapport;
use App\Models\Validation;
use App\Models\Journalisation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rapport>
 */
class RapportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'periode_id' => Periode::factory(),
            'statut' => fake()->randomElement(['brouillon', 'soumis', 'valide', 'rejete']),
            'contenu' => [
                'realisations' => fake()->paragraphs(3, true),
                'difficultes' => fake()->optional()->paragraph(),
                'pourcentage' => fake()->numberBetween(0, 100),
            ],
            'date_soumission' => fake()->optional()->dateTimeThisMonth(),
        ];
    }
}
