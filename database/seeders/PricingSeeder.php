<?php

namespace Database\Seeders;

use App\Models\CourtType;
use App\Models\Pricing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtiene todos los IDs de los tipos de canchas creados por el CourtTypeSeeder
        $courtTypeIds = CourtType::pluck('id')->all();

        // Inicializa la instancia de Faker
        $faker = Faker::create();

        // Crea 6 franjas de precios, asociándolas aleatoriamente a los tipos de cancha
        Pricing::factory(6)->create([
            'court_type_id' => $faker->randomElement($courtTypeIds),
        ]);
    }
}
