<?php

namespace App\Livewire\Forms\Admin;

use App\Models\CourtType;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CourtTypeForm extends Form
{
    public ?CourtType $courtType = null;

    public $nombre = '';

    #[Validate('nullable|string|max:255')]
    public $descripcion = '';

    public function rules() {
        return [
            'nombre' => [
                'required',
                'string',
                'max:100',
                Rule::unique('court_types', 'nombre')->ignore($this->courtType),
            ],
        ];
    }

    // Usado en edición
    public function setCourtType(CourtType $courtType) {
        $this->courtType = $courtType;
        $this->nombre = $courtType->nombre;
        $this->descripcion = $courtType->descripcion;
    }


    public function store(): CourtType {
        $this->validate();
        return $courtType = CourtType::create($this->only([
            'nombre',
            'descripcion'
        ]));
    }

    public function update(): void {
        $this->validate();
        $this->courtType->update($this->all());
        $this->reset();
    }
}
