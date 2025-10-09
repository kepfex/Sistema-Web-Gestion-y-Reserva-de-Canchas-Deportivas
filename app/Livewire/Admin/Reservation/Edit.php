<?php

namespace App\Livewire\Admin\Reservation;

use App\Livewire\Forms\Admin\ReservationForm;
use App\Models\Court;
use App\Models\Reservation;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Editar - Reserva'])]
class Edit extends Component
{
    public ReservationForm $form;
    public Reservation $reservation;

    public function mount(Reservation $reservation) {
        $this->reservation = $reservation;
        $this->form->setReservation($reservation);
    }

    public function save()
    {
        $this->form->update();

        $notification = [
            'variant' => 'success',
            'title'   => '¡Actualizada!',
            'message' => 'La reservación se actualizó correctamente.'
        ];
        
        session()->flash('notify', $notification);
        $this->redirect(route('admin.reservations.index'), navigate: true);
    }

    public function render()
    {
        $users = User::all();
        $courts = Court::where('disponible', true)->get();

        return view('livewire.admin.reservation.form', [
            'breadcrumbsText' => 'Editar',
            'title' => 'Editar Reserva',
            'buttonText' => 'Guardar Cambios',
            'users' => $users,
            'courts' => $courts,
        ]);
    }
}
