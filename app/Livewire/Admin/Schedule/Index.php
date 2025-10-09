<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Schedule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Horarios'])]
class Index extends Component
{
    use WithPagination;
    
    public $paginarX = "5";
    public $search = '';

    public function updatingPaginarX()
    {
        $this->resetPage('schedulesPage');
    }
    public function updatingSearch()
    {
        $this->resetPage('schedulesPage');
    }

    // Metodo para eliminar
    #[On('delete-schedule')] // Escuchamos la accion enviado con dispatch
    public function deleteSchedule($id)
    {

        $schedule = Schedule::find($id);

        if ($schedule) {

            $schedule->delete();

            // Enviamos un dispatch
            $this->dispatch(
                'notify',
                variant: 'success',
                title: '¡Eliminado!',
                message: 'El Horario se eliminó correctamente.'
            );
        }
    }
    
    public function render()
    {
        $schedules = Schedule::where('dia_de_la_semana', 'like', '%'.$this->search.'%')
            ->orderby('id', 'desc')->paginate($this->paginarX, ['*'], 'schedulesPage');

        return view('livewire.admin.schedule.index', [
            'schedules' => $schedules,
            'titulo' => 'Horarios',
        ]);
    }
}
