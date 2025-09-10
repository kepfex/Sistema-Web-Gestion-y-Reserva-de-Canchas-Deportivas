<?php

namespace App\Livewire\Forms\Admin;

use App\Models\Court;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CourtForm extends Form
{
    // Define las propiedades del formulario.
    public ?Court $court;
    
    #[Rule('required|exists:court_types,id', as: 'tipo de cancha')]
    public $court_type_id = '';
    
    #[Rule('required|min:3', as: 'nombre de la cancha')]
    public $nombre = '';

    #[Rule('nullable|string|min:5')]
    public $medidas = '';

    #[Rule('nullable|string|min:5', as: 'ubicación')]
    public $ubicacion = '';

    #[Rule('required|boolean')]
    public $disponible = true;

    // Métodos para llenar el formulario, Usado en edición
    public function setCourt(Court $court)
    {
        $this->court = $court;
        $this->court_type_id = $court->court_type_id;
        $this->nombre = $court->nombre;
        $this->medidas = $court->medidas;
        $this->ubicacion = $court->ubicacion;
        $this->disponible = (bool) $court->disponible;
    }

    public function store(): Court {
        $this->validate();
        return $court = Court::create($this->only([
            'nombre',
            'medidas',
            'ubicacion',
            'disponible',
            'court_type_id',
        ]));
    }

    public function update(): void {
        $this->validate();
        $this->court->update($this->all());
        $this->reset();
    }

}
