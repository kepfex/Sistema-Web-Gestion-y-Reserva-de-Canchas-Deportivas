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
        $horarios = [
            ['dia_de_la_semana' => 'Lunes', 'hora_apertura' => '08:00:00', 'hora_cierre' => '10:00'],
            ['dia_de_la_semana' => 'Martes', 'hora_apertura' => '08:00:00', 'hora_cierre' => '10:00'],
            ['dia_de_la_semana' => 'Miércoles', 'hora_apertura' => '08:00:00', 'hora_cierre' => '10:00'],
            ['dia_de_la_semana' => 'Jueves', 'hora_apertura' => '08:00:00', 'hora_cierre' => '10:00'],
            ['dia_de_la_semana' => 'Viernes', 'hora_apertura' => '08:00:00', 'hora_cierre' => '10:00'],
            ['dia_de_la_semana' => 'Sábado', 'hora_apertura' => '08:00:00', 'hora_cierre' => '10:00'],
        ];

        foreach($horarios as $item) {
            Schedule::create([
                ...$item,
                'court_id' => 1
            ]);
        }
    }
}
