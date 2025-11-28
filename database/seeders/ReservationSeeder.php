<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. obtenemos los ids de usuarios y canchas
        $userIDs = User::pluck('id')->all();
        $courtIDs = Court::pluck('id')->all();

        // 2. definir los posibles estados 
        $states = ['pendiente', 'confirmada', 'cancelada', 'completada'];

        // 3. verificamos si existen datos
        if (empty($userIDs) || empty($courtIDs)) {
            $this->command->info('No se pueden crear reservaciones porque faltan usuarios o canchas deportivas.');
            return;
        }

        // 4. Crear 15 registros para reservaciones
        for ($i = 0; $i < 15; $i++) {
            // 5. generar fechas y horas aleatorias
            $startDate = Carbon::now()
                ->addDays(rand(0, 7))
                ->setHour(rand(8, 20))
                ->setMinute(0)
                ->setSecond(0);

            // duracion: 1 o 2 horas
            $durationInHours = rand(1, 2);

            // Fecha fin: se calcula sumando la duracion
            $endDate = $startDate->copy()->addHours($durationInHours);

            // Elegir estado aleatorio
            $estado = $states[array_rand($states)];

            // Inicializar valores financieros
            $precioSnapshot = null;
            $total = 0;

            // Solo si la reserva está confirmada o completada calculamos precio y total
            if (in_array($estado, ['confirmada', 'completada'])) {
                // Determinar si es día o noche según la hora de inicio
                $horaInicio = (int) $startDate->format('H'); // 0..23

                // Regla: día 06:00-17:59 => S/30 ; noche 18:00-05:59 => S/35
                if ($horaInicio >= 6 && $horaInicio < 18) {
                    $precioPorHora = 30.00;
                } else {
                    $precioPorHora = 35.00;
                }

                // Calcular duración real en horas (puede ser fraccional)
                $duracionMinutos = $startDate->diffInMinutes($endDate);
                $duracionHoras = $duracionMinutos / 60;

                // Calcular total y snapshot
                $precioSnapshot = round($precioPorHora, 2);
                $total = round($precioPorHora * $duracionHoras, 2);
            }

            // 6. Crear la reservacion en la bd
            Reservation::create([
                'user_id' => $userIDs[array_rand($userIDs)],
                'court_id' => $courtIDs[array_rand($courtIDs)],
                'fecha_hora_inicio' => $startDate,
                'fecha_hora_fin' => $endDate,
                'estado' => $estado,
                'precio_snapshot' => $precioSnapshot,
                'total' => $total,
            ]);
        }
    }
}
