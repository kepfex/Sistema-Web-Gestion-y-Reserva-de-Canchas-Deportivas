<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\CourtType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $canchas = [
            ['nombre' => 'Cancha 1', 'medidas' => '20m x 30m', 'ubicacion' => 'Local 1 - cancha principal'],
            ['nombre' => 'Cancha 2', 'medidas' => '15m x 20m', 'ubicacion' => 'Local 1 - cancha secundaria'],
        ];
        
        foreach($canchas as $cancha) {
            Court::create([
                ...$cancha,
                'disponible' => 1,
                'court_type_id' => 3
            ]);
        }
    }
}
