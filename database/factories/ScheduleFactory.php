<?php

namespace Database\Factories;

use App\Models\Court;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'court_id' => Court::factory(),
            'dia_de_la_semana' => $this->faker->randomElement(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo']),
            'hora_apertura' => $this->faker->time('H:i:s'),
            'hora_cierre' => $this->faker->time('H:i:s'),
        ];
    }
}
