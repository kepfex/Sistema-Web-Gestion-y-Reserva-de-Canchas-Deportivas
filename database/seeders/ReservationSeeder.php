<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtiene todos los IDs de usuarios y canchas
        $userIds = User::pluck('id')->all();
        $courtIds = Court::pluck('id')->all();

        // Inicializa la instancia de Faker
        $faker = Faker::create();

        // Crea 50 reservas, asociándolas aleatoriamente a usuarios y canchas
        Reservation::factory(50)->create([
            'user_id' => $faker->randomElement($userIds),
            'court_id' => $faker->randomElement($courtIds),
        ]);
    }
}
