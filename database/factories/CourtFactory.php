<?php

namespace Database\Factories;

use App\Models\CourtType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Court>
 */
class CourtFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'court_type_id' => CourtType::factory(),
            'nombre' => 'Cancha ' . $this->faker->numberBetween(1, 10),
            'medidas' => $this->faker->randomElement(['20m x 40m', '18m x 36m', '15m x 28m']),
            'ubicacion' => $this->faker->streetAddress(),
            'disponible' => $this->faker->boolean(),
        ];
    }
}
