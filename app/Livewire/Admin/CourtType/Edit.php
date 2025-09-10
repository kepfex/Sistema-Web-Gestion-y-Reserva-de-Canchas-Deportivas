<?php

namespace App\Livewire\Admin\CourtType;

use App\Livewire\Forms\Admin\CourtTypeForm;
use App\Models\CourtType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Editar - Tipo de Cancha'])]
class Edit extends Component
{
    public CourtTypeForm $form;
    public CourtType $courtType;

    public function mount(CourtType $courtType)
    {
        $this->courtType = $courtType;
        $this->form->setCourtType($courtType);
    }

    public function save()
    {
        $this->form->update();

         // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Actualizado!',
            'message' => 'El Tipo de Cancha se actuzalizó correctamente.'
        ];

        // Envía la notificación a la sesión flash
        session()->flash('notify', $notification);

        // Redirige a la página del listado usando la navegación de Livewire
        $this->redirect(route('admin.court-types.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.court-type.form', [
            'breadcrumbsText' => 'Editar',
            'title' => 'Editar Tipo de Cancha',
            'buttonText' => 'Guardar Cambios',
        ]);
    }
}
