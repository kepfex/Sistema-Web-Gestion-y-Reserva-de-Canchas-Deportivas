<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // Obtiene todos los IDs de usuarios y canchas
        // $userIds = User::pluck('id')->all();
        // $courtIds = Court::pluck('id')->all();

        // // Inicializa la instancia de Faker
        // $faker = Faker::create();

        // // Crea 50 reservas, asociándolas aleatoriamente a usuarios y canchas
        // Reservation::factory(50)->create([
        //     'user_id' => $faker->randomElement($userIds),
        //     'court_id' => $faker->randomElement($courtIds),
        // ]);

        // 1. obtenemos los ids de usuarios y canchas
        $userIDs = User::pluck('id')->all();
        $courtIDs = User::pluck('id')->all();

        // 2. definir los posibles estados 
        $states = ['pendiente', 'confirmada', 'cancelada', 'completada'];

        // 3. verificamos si existen datos
        if (empty($userIDs) || empty($courtIDs)) {
            $this->command->info('No se pueden crear reservaciones porque faltan usuarios o canchas deportivas.1');
            return;
        }

        // 4. Crear 15 registros para reservaciones
        for ($i=0; $i < 15; $i++) { 
            // 5. generar fechas y horas aleatorias
            $startDate = Carbon::now()
                ->addDays(rand(0, 7))
                ->setHour(rand(8, 20))
                ->setMinute(0)
                ->setSecond(0);

            // duracion: 1 o 2 horas
            $durationInHours = rand(1, 2);

            // Fecha fin: se calcula sumando la duarcion
            $endDate = $startDate->copy()->addHours($durationInHours);
            
            // 6. Crear la reservacion en la bd
            Reservation::create([
                'user_id' => $userIDs[array_rand($userIDs)],
                'court_id' => $courtIDs[array_rand($courtIDs)],
                'fecha_hora_inicio' => $startDate,
                'fecha_hora_fin' => $endDate,
                'estado' => $states[array_rand($states)],
            ]);
        }
    }
}
