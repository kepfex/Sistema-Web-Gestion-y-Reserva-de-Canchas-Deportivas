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
        $precios = [
            ['hora_inicio' => '07:00:00', 'hora_fin' => '18:29:00', 'precio_por_hora' => '30.00', 'es_precio_nocturno' => 0],
            ['hora_inicio' => '18:30:00', 'hora_fin' => '23:59:00', 'precio_por_hora' => '35.00', 'es_precio_nocturno' => 1],
        ];

        foreach ($precios as $item) {
            Pricing::create([
                ...$item,
                'court_type_id' => 3
            ]);
        }
    }
}
