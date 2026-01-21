<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periode>
 */
class PeriodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', 'now');
        return [
            'libelle' => 'Semaine ' . fake()->numberBetween(1, 52) . ' - ' . $start->format('Y'),
            'date_debut' => $start->format('Y-m-d'),
            'date_fin' => (clone $start)->modify('+6 days')->format('Y-m-d'),
            'statut' => 'cloturee',
        ];
    }
}
