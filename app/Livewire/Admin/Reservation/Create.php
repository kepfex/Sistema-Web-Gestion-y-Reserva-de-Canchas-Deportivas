<?php

namespace App\Livewire\Admin\Reservation;

use App\Livewire\Forms\Admin\ReservationForm;
use App\Models\Court;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    public ReservationForm $form;

    public function save() {
        $this->form->store();

        $notification = [
            'variant' => 'success',
            'title'   => '¡Creada!',
            'message' => 'La reservación se creó correctamente.'
        ];

        session()->flash('notify', $notification);
        $this->redirect(route('admin.reservations.index'), navigate: true);
    }
    
    public function render()
    {
        $users = User::all();
        $courts = Court::where('disponible', true)->get();
        
        return view('livewire.admin.reservation.form', [
            'breadcrumbsText' => 'Nueva',
            'title' => 'Crear Reservación',
            'buttonText' => 'Guardar',
            'users' => $users,
            'courts' => $courts,
        ]);
    }
}
