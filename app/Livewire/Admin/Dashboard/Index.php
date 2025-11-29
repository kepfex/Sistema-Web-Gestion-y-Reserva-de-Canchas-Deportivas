<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Court;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Dashboard'])]
class Index extends Component
{

    public $fechaHoy;

    public function mount()
    {
        $this->fechaHoy = today()->format('Y-m-d');
    }

    public function reservasPorEstadoHoy(): array
    {
        // Definimos los estados esperados
        $estados = ['pendiente', 'confirmada', 'cancelada', 'completada'];

        // 1. Optimización SQL: Usamos 'toBase()' para evitar hidratar modelos Eloquent
        // (es mucho más rápido para conteos simples)
        $reservas = Reservation::toBase()
            ->selectRaw('estado, count(*) as total')
            ->whereDate('fecha_hora_inicio', $this->fechaHoy)
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->toArray();

        // 2. Optimización PHP: Usamos unión de arrays (+) en lugar de foreach
        // 'array_fill_keys' crea un array base: ['pendiente' => 0, 'confirmada' => 0...]
        // El operador '+' fusiona los resultados de la BD sobre los ceros, respetando las claves existentes.
        return $reservas + array_fill_keys($estados, 0);
    }

    public function obtenerColeccion(): Collection
    {
        return collect([1, 2, 3]);
    }

    public function render()
    {
        $hoy = $this->fechaHoy;
        // 1. Total reservas
        $totalReservas = Reservation::count();

        // 2. Reservas por estado
        $reservasPorEstado = Reservation::select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $reservasPorEstadoHoy = Reservation::select('estado', DB::raw('COUNT(*) as total'))
            ->whereDate('fecha_hora_inicio', $hoy)
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // 👉 Reservas del día
        $reservasHoy = Reservation::whereDate('fecha_hora_inicio', $hoy)
            ->orWhereDate('fecha_hora_fin', $hoy)
            ->count();

        // 3. Total usuarios registrados
        $totalUsuarios = User::count();

        // 4. Total canchas activas
        $canchasActivas = Court::where('disponible', 1)->count();

        // 5. Ingresos totales confirmados o completados
        $totalIngresos = Reservation::whereIn('estado', ['confirmada', 'completada'])
            ->sum('total');

        // 6. Ingresos por día (últimos 7 días)
        $ingresosPorDia = Reservation::whereIn('estado', ['confirmada', 'completada'])
            ->select(
                DB::raw('DATE(fecha_hora_inicio) as fecha'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('fecha')
            ->orderBy('fecha', 'ASC')
            ->get();

        // 7. Reservas por tipo de cancha
        $reservasPorTipo = DB::table('reservations')
            ->join('courts', 'reservations.court_id', '=', 'courts.id')
            ->join('court_types', 'courts.court_type_id', '=', 'court_types.id')
            ->select('court_types.nombre', DB::raw('COUNT(reservations.id) as total'))
            ->groupBy('court_types.nombre')
            ->get();

        // 8. Horas más reservadas
        $horasPopulares = Reservation::select(
            DB::raw('HOUR(fecha_hora_inicio) as hora'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('hora')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // 9. Ocupación de canchas hoy
        $ocupacionHoy = Reservation::whereDate('fecha_hora_inicio', now()->toDateString())
            ->count();

        return view('livewire.admin.dashboard.index', [
            'totalReservas' => $totalReservas,
            'reservasPorEstado' => $reservasPorEstado,
            'reservasHoy' => $reservasHoy,
            'reservasPorEstadoHoy' => $reservasPorEstadoHoy,

        ]);
    }
}
