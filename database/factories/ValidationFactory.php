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
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Validation>
 */
class ValidationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rapport_id' => Rapport::factory(),
            'valideur_id' => User::factory(),
            'commentaire' => fake()->optional()->paragraph(),
            'statut' => fake()->randomElement(['valide', 'rejete']),
            'date_validation' => fake()->dateTimeThisMonth(),
        ];
    }
}
