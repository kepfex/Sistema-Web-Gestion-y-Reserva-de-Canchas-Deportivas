<?php

namespace App\Livewire\Admin\CourtType;

use App\Livewire\Forms\Admin\CourtTypeForm;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Crear Tipo de Cancha'])]
class Create extends Component
{
    public CourtTypeForm $form;

    public function save() {
        $this->form->store();

        // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Creado!',
            'message' => 'El Tipo de Cancha se creó correctamente.'
        ];

        // Envía la notificación a la sesión flash
        session()->flash('notify', $notification);

        // Redirige a la página del listado usando la navegación de Livewire
        $this->redirect(route('admin.court-types.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.court-type.form', [
            'breadcrumbsText' => 'Nuevo',
            'title' => 'Crear Tipo de Cancha Deportiva',
            'buttonText' => 'Guardar',
        ]);
    }
}
