<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Schedule;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ScheduleForm extends Form
{
    // Propiedad para el modelo Schedule si se está editando.
    public ?Schedule $schedule = null;
    
    // Validación para el día de la semana.
    #[Rule('required|in:lunes,martes,miércoles,jueves,viernes,sábado,domingo')]
    public $dia_de_la_semana = '';

    // Validación para la hora de apertura.
    #[Rule('required|date_format:H:i')]
    public $hora_apertura = '';

    // Validación para la hora de cierre.
    #[Rule('required|date_format:H:i|after:hora_apertura')]
    public $hora_cierre = '';

    // Validación para el ID de la cancha.
    #[Rule('required|exists:courts,id')]
    public $court_id = '';
    
    // Llena el formulario con los datos de un modelo de Schedule.
    public function setSchedule(Schedule $schedule)
    {
        $this->schedule = $schedule;
        $this->dia_de_la_semana = $schedule->dia_de_la_semana;
        
        // Formateamos las horas para que coincidan con el formato 'H:i' de la validación.
        $this->hora_apertura = date('H:i', strtotime($schedule->hora_apertura));
        $this->hora_cierre = date('H:i', strtotime($schedule->hora_cierre));
        
        $this->court_id = $schedule->court_id;
    }

    // Guarda un nuevo horario en la base de datos.
    public function store(): Schedule
    {
        $this->validate();

        Schedule::create($this->all());
        return $schedule = Schedule::create($this->only([
            'dia_de_la_semana',
            'hora_apertura',
            'hora_cierre',
            'court_id',
        ]));
    }
    
    // Actualiza un horario existente.
    public function update()
    {
        $this->validate();

        $this->schedule->update($this->all());

        $this->reset();
    }
}
