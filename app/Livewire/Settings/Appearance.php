<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class Appearance extends Component
{
    public $form = [
        'appearance' => null,
    ];

    public function mount()
    {
        // Si no existe, poner "system" como valor inicial
        $this->form['appearance'] = $this->form['appearance'] ?? 'light';
    }

    public function save()
    {
        // Aquí guardas en base de datos si quieres
        // auth()->user()->update(['appearance' => $this->form['appearance']]);

        session()->flash('success', 'Apariencia actualizada.');
    }

    public function render()
    {
        return view('livewire.settings.appearance');
    }
}
