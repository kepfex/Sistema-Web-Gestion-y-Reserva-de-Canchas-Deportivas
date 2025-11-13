<?php

namespace App\Http\Controllers\Api\Guest;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index() {
        // Obtenemos todas las reservaciones con sus relaciones
        $reservations = Reservation::with(['user', 'court'])->get();

        // Mapeamos los datos al formato que espea Fullcalendar
        $events = $reservations->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'title' => $reservation->court->nombre . ' (' . $reservation->user->name . ')',
                'start' => $reservation->fecha_hora_inicio->format('Y-m-d\TH:i:s'),
                'end' => $reservation->fecha_hora_fin->format('Y-m-d\TH:i:s'),
                'color' => $this->getColorByState($reservation->estado),
                'estado' => $reservation->estado,
            ];
        });

        // Devolvemos los eventos como JSON
        return response()->json($events);
    }

    private function getColorByState($estado) {
        switch ($estado) {
            case 'pendiente':
                return '#f59e0b';
            case 'confirmada':
                return '#10b981'; 
            case 'cancelada':
                return '#ef4444'; 
            case 'completada':
                return '#3b82f6'; 

            default:
                return '#6b280'; 
        }
    }
}
