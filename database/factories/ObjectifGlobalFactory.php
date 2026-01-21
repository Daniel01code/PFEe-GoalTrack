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
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ObjectifGlobal>
 */
class ObjectifGlobalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'periode_id' => Periode::factory(),
            'service_id' => Service::factory(),
            'description' => fake()->sentence(),
            'cible' => fake()->numberBetween(50, 500),
            'unite' => fake()->randomElement(['contrats', 'clients', 'CA en FCFA', 'visites']),
        ];
    }
}
