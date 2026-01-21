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
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journalisation>
 */
class JournalisationFactory extends Factory
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
            'action' => fake()->randomElement(['login', 'create_objectif', 'submit_rapport', 'validate_rapport']),
            'details' => fake()->sentence(),
        ];
    }
}
