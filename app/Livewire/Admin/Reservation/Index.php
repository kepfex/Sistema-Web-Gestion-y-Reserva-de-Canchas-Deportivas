<?php

namespace App\Livewire\Admin\Reservation;

use App\Models\Reservation;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    
    public $paginarX = "10";
    public $search = '';

    public function updatingPaginarX()
    {
        $this->resetPage('reservationsPage');
    }
    public function updatingSearch()
    {
        $this->resetPage('reservationsPage');
    }
    
    // Metodo para eliminar
    #[On('delete-reservation')]
    public function deleteReservation($id)
    {
        $reservation = Reservation::find($id);

        if ($reservation) {
            $reservation->delete();
            $this->dispatch(
                'notify',
                variant: 'success',
                title: '¡Eliminada!',
                message: 'La reservación se eliminó correctamente.'
            );
        }
    }

    public function render()
    {
        $reservations = Reservation::with(['user', 'court'])
            ->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('court', function ($query) {
                $query->where('nombre', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate($this->paginarX, ['*'], 'reservationsPage');

        return view('livewire.admin.reservation.index', [
            'reservations' => $reservations,
            'titulo' => 'Reservaciones',
        ]);
    }
}
