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
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ObjectifIndividuel>
 */
class ObjectifIndividuelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'objectif_global_id' => ObjectifGlobal::factory(),
            'user_id' => User::factory(),
            'cible_personnelle' => fake()->numberBetween(10, 100),
            'pourcentage_atteinte' => fake()->randomFloat(2, 0, 100),
            'commentaire' => fake()->optional()->paragraph(),
            'statut' => fake()->randomElement(['assigne', 'atteint', 'partiel']),
        ];
    }
}
