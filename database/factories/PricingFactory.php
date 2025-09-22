<?php

namespace Database\Factories;

use App\Models\CourtType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pricing>
 */
class PricingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'court_type_id' => CourtType::factory(),
            'hora_inicio' => $this->faker->time('H:i:s'),
            'hora_fin' => $this->faker->time('H:i:s'),
            'precio_por_hora' => $this->faker->randomFloat(2, 20, 100),
            'es_precio_nocturno' => $this->faker->boolean(),
        ];
    }
}
