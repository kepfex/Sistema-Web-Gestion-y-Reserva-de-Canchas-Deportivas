<?php

namespace App\Livewire\Admin\Court;

use App\Livewire\Forms\Admin\CourtForm;
use App\Models\CourtType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Crear - Cancha Deportiva'])]
class Create extends Component
{
    public CourtForm $form;

    public function save() {
        $this->form->store();

        // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Creado!',
            'message' => 'La Cancha Deportiva se creó correctamente.'
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
            'breadcrumbsText' => 'Nuevo',
            'title' => 'Crear Cancha Deportiva',
            'buttonText' => 'Guardar',
            'courtTypes' => $courtTypes,
        ]);
    }
}
