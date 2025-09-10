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
        // Obtiene los tipos de canchas existentes para usarlos en la creación de canchas.
        $courtTypes = CourtType::all();

        // Crea 10 canchas en total.
        for ($i = 0; $i < 10; $i++) {
            Court::factory()->create([
                'court_type_id' => $courtTypes->random()->id,
            ]);
        }
    }
}
