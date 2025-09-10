<?php

namespace App\Livewire\Admin\Court;

use App\Livewire\Forms\Admin\CourtForm;
use App\Models\Court;
use App\Models\CourtType;
use Livewire\Component;

class Edit extends Component
{
    public CourtForm $form;
    public Court $court;

    public function mount(Court $court)
    {
        $this->court = $court;
        $this->form->setCourt($court);
    }

    public function save()
    {
        $this->form->update();

         // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Actualizado!',
            'message' => 'La Cancha Deportiva se actuzalizó correctamente.'
        ];

        // Envía la notificación a la sesión flash
        session()->flash('notify', $notification);

        // Redirige a la página del listado usando la navegación de Livewire
        $this->redirect(route('admin.courts.index'), navigate: true);
    }

    public function render()
    {
        $courtTypes = CourtType::all();
        
        return view('livewire.admin.court.form', [
            'breadcrumbsText' => 'Editar',
            'title' => 'Editar Cancha Deportiva',
            'buttonText' => 'Guardar Cambios',
            'courtTypes' => $courtTypes,
        ]);
    }
}
