<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtiene todos los IDs de las canchas creadas previamente
        $courtIds = Court::pluck('id')->all();

        // Inicializa la instancia de Faker
        $faker = Faker::create();

        // Crea 10 horarios, asociándolos aleatoriamente a una de las canchas
        Schedule::factory(10)->create([
            'court_id' => $faker->randomElement($courtIds),
        ]);
    }
}
