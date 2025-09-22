<?php

namespace Database\Factories;

use App\Models\Court;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'user_id' => User::factory(),
            // 'court_id' => Court::factory(),
            'fecha_hora_inicio' => $this->faker->dateTimeBetween('now', '+1 month'),
            'fecha_hora_fin' => $this->faker->dateTimeBetween('now', '+1 month'),
            'estado' => $this->faker->randomElement(['pendiente', 'confirmada', 'cancelada', 'completada']),
        ];
    }
}
