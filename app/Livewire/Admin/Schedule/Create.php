<?php

namespace App\Livewire\Admin\Schedule;

use App\Livewire\Forms\Admin\ScheduleForm;
use App\Models\Court;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Crear - Horario'])]
class Create extends Component
{
    public ScheduleForm $form;

    public function save() {
        $this->form->store();

        // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Creado!',
            'message' => 'El Horario se creó correctamente.'
        ];

        // Envía la notificación a la sesión flash
        session()->flash('notify', $notification);

        // Redirige a la página del listado usando la navegación de Livewire
        $this->redirect(route('admin.schedules.index'), navigate: true);
    }

    public function render()
    {
        $courts = Court::all();

        return view('livewire.admin.schedule.form', [
            'breadcrumbsText' => 'Nuevo',
            'title' => 'Crear Horario',
            'buttonText' => 'Guardar',
            'courts' => $courts,
        ]);
    }
}
