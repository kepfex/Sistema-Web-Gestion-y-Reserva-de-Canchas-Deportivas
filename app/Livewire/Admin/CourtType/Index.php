<?php

namespace App\Livewire\Admin\CourtType;

use App\Models\CourtType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Tipo de Canchas'])]
class Index extends Component
{
    use WithPagination;
    
    public $paginarX = "5";
    public $search = '';

    public function updatingPaginarX()
    {
        $this->resetPage('court-tyesPage');
    }
    public function updatingSearch()
    {
        $this->resetPage('court-tyesPage');
    }

    // Metodo para eliminar una categoría
    #[On('delete-courtype')] // Escuchamos la accion enviado con dispatch
    public function deleteCategoria($id)
    {

        $courtType = CourtType::find($id);

        if ($courtType) {

            $courtType->delete();

            // Enviamos un dispatch
            $this->dispatch(
                'notify',
                variant: 'success',
                title: '¡Eliminado!',
                message: 'El Tipo de Cancha se eliminó correctamente.'
            );
        }
        // $this->loadCategories();
    }

    public function render()
    {
        $courtTypes = CourtType::where('nombre', 'like', '%'.$this->search.'%')
            ->orderby('id', 'desc')->paginate($this->paginarX, ['*'], 'court-tyesPage');

        return view('livewire.admin.court-type.index', [
            'courtTypes' => $courtTypes,
            'titulo' => 'Tipos de Canchas',
        ]);
    }
}
