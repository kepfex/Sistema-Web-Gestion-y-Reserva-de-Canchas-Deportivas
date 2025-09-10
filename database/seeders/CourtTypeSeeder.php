<?php

namespace Database\Seeders;

use App\Models\CourtType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourtTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea tipos de canchas con sus respectivos nombres y descripciones.
        CourtType::factory()->create(['nombre' => 'Fútbol 7', 'descripcion' => 'Cancha de césped sintético para partidos de fútbol 7.']);
        CourtType::factory()->create(['nombre' => 'Vóley Playa', 'descripcion' => 'Cancha de arena para partidos de vóley playa.']);
        CourtType::factory()->create(['nombre' => 'Básquetbol', 'descripcion' => 'Cancha de asfalto para partidos de básquetbol.']);
    }
}
