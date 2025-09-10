<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Pricing;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PricingForm extends Form
{
    // Propiedad para el modelo Pricing si se está editando.
    public ?Pricing $pricing = null;

    // Validación para el ID del tipo de cancha.
    #[Rule('required|exists:court_types,id')]
    public $court_type_id = '';
    
    // Validación para la hora de inicio (formato H:i).
    #[Rule('required|date_format:H:i')]
    public $hora_inicio = '';

    // Validación para la hora de fin (formato H:i y debe ser posterior a la hora de inicio).
    #[Rule('required|date_format:H:i|after:hora_inicio')]
    public $hora_fin = '';

    // Validación para el precio.
    #[Rule('required|numeric|min:0')]
    public $precio_por_hora = 0;

    // Validación para el estado booleano.
    #[Rule('required|boolean')]
    public $es_precio_nocturno = false;

    // Llena el formulario con los datos de un modelo de Pricing.
    public function setPricing(Pricing $pricing)
    {
        $this->pricing = $pricing;
        $this->court_type_id = $pricing->court_type_id;
        
        // Formateamos las horas para que coincidan con el formato 'H:i' de la validación.
        $this->hora_inicio = date('H:i', strtotime($pricing->hora_inicio));
        $this->hora_fin = date('H:i', strtotime($pricing->hora_fin));

        $this->precio_por_hora = $pricing->precio_por_hora;
        $this->es_precio_nocturno = (bool) $pricing->es_precio_nocturno;
    }

    // Guarda una nueva franja de precio en la base de datos.
    public function store(): Pricing {
        $this->validate();
        return $pricing = Pricing::create($this->only([
            'court_type_id',
            'hora_inicio',
            'hora_fin',
            'precio_por_hora',
            'es_precio_nocturno',
        ]));
    }
    
    // Actualiza una franja de precio existente.
    public function update() {
        $this->validate();
        $this->pricing->update($this->all());
        $this->reset();
    }
}
