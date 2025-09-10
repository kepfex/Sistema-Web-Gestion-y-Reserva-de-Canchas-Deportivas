<?php

namespace App\Livewire\Admin\Pricing;

use App\Models\Pricing;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Precios'])]
class Index extends Component
{
    use WithPagination;
    
    public $paginarX = "5";
    public $search = '';

    public function updatingPaginarX()
    {
        $this->resetPage('pricingsPage');
    }
    public function updatingSearch()
    {
        $this->resetPage('pricingsPage');
    }

    // Metodo para eliminar
    #[On('delete-pricing')] // Escuchamos la accion enviado con dispatch
    public function deletePricing($id)
    {

        $pricing = Pricing::find($id);

        if ($pricing) {

            $pricing->delete();

            // Enviamos un dispatch
            $this->dispatch(
                'notify',
                variant: 'success',
                title: '¡Eliminado!',
                message: 'El Precio se eliminó correctamente.'
            );
        }
    }
    
    public function render()
    {
        $pricings = Pricing::where('hora_inicio', 'like', '%'.$this->search.'%')
            ->orderby('id', 'desc')->paginate($this->paginarX, ['*'], 'pricingsPage');

        return view('livewire.admin.pricing.index', [
            'pricings' => $pricings,
            'titulo' => 'Precios',
        ]);
    }
}
