<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourtType>
 */
class CourtTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement(['Fútbol 7', 'Vóley Playa', 'Básquetbol', 'Tenis', 'Fútbol Sala']),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
