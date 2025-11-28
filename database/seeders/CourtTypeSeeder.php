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
        CourtType::create(['nombre' => 'Fulbito', 'descripcion' => 'Cancha de césped sintético para partidos con cantidad reducida de jugadores']); // id 1
        CourtType::create(['nombre' => 'Vóley', 'descripcion' => 'Cancha de césped sintético para partidos de vóley playa.']); // id 2
        CourtType::create(['nombre' => 'Multiuso (Fulbito - Vóley)', 'descripcion' => 'Cancha de césped sintético para partidos de fulbito o vóley.']); // id 3
        CourtType::create(['nombre' => 'Básquetbol', 'descripcion' => 'Cancha de asfalto para partidos de básquetbol.']); // id 3
    }
}
