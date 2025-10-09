<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Reservation;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ReservationForm extends Form
{
    public ?Reservation $reservation;

    #[Rule('required|exists:users,id', as: 'usuario')]
    public $user_id = '';

    #[Rule('required|exists:courts,id', as: 'cancha')]
    public $court_id = '';

    #[Rule('required|date', as: 'fecha y hora de inicio')]
    public $fecha_hora_inicio = '';

    #[Rule('required|date|after:fecha_hora_inicio', as: 'fecha y hora de fin')]
    public $fecha_hora_fin = '';

    #[Rule('required|in:pendiente,confirmada,cancelada,completada', as: 'estado')]
    public $estado = 'pendiente';

    public function setReservation(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $this->user_id = $reservation->user_id;
        $this->court_id = $reservation->court_id;
        // Formatear las fechas para el input datetime-local
        $this->fecha_hora_inicio = \Carbon\Carbon::parse($reservation->fecha_hora_inicio)->format('Y-m-d\TH:i');
        $this->fecha_hora_fin = \Carbon\Carbon::parse($reservation->fecha_hora_fin)->format('Y-m-d\TH:i');
        $this->estado = $reservation->estado;
    }

    public function store()
    {
        $this->validate();
        Reservation::create($this->all());
    }

    public function update()
    {
        $this->validate();
        $this->reservation->update($this->all());
    }
}
