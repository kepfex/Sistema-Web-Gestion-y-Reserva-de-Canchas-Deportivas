<?php

namespace App\Livewire\Admin\Court;

use App\Models\Court;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Canchas Deportivas'])]
class Index extends Component
{
    use WithPagination;
    
    public $paginarX = "5";
    public $search = '';

    public function updatingPaginarX()
    {
        $this->resetPage('courtsPage');
    }
    public function updatingSearch()
    {
        $this->resetPage('courtsPage');
    }

    // Metodo para eliminar
    #[On('delete-court')] // Escuchamos la accion enviado con dispatch
    public function deleteCourt($id)
    {

        $court = Court::find($id);

        if ($court) {

            $court->delete();

            // Enviamos un dispatch
            $this->dispatch(
                'notify',
                variant: 'success',
                title: '¡Eliminado!',
                message: 'El Tipo de Cancha se eliminó correctamente.'
            );
        }
    }

    public function render()
    {
        $courts = Court::where('nombre', 'like', '%'.$this->search.'%')
            ->orderby('id', 'desc')->paginate($this->paginarX, ['*'], 'courtsPage');

        return view('livewire.admin.court.index', [
            'courts' => $courts,
            'titulo' => 'Canchas Deportivas',
        ]);
    }
}
