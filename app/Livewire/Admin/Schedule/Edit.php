<?php

namespace App\Livewire\Admin\Schedule;

use App\Livewire\Forms\Admin\ScheduleForm;
use App\Models\Court;
use App\Models\Schedule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Editar - Horario'])]
class Edit extends Component
{
    public ScheduleForm $form;
    public Schedule $schedule;

    public function mount(Schedule $schedule)
    {
        $this->schedule = $schedule;
        $this->form->setSchedule($schedule);
    }

    public function save()
    {
        $this->form->update();

         // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Actualizado!',
            'message' => 'El Horario se actuzalizó correctamente.'
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
            'breadcrumbsText' => 'Editar',
            'title' => 'Editar Horario',
            'buttonText' => 'Guardar Cambios',
            'courts' => $courts,
        ]);
    }
}
