<?php

namespace App\Livewire\Admin\Pricing;

use App\Livewire\Forms\Admin\PricingForm;
use App\Models\CourtType;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Crear - Precio'])]
class Create extends Component
{
    public PricingForm $form;

    public function save() {
        $this->form->store();

        // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Creado!',
            'message' => 'El Precio se creó correctamente.'
        ];

        // Envía la notificación a la sesión flash
        session()->flash('notify', $notification);

        // Redirige a la página del listado usando la navegación de Livewire
        $this->redirect(route('admin.pricings.index'), navigate: true);
    }
    
    public function render()
    {
        $courtTypes = CourtType::all();
        
        return view('livewire.admin.pricing.form', [
            'breadcrumbsText' => 'Nuevo',
            'title' => 'Crear Precio',
            'buttonText' => 'Guardar',
            'courtTypes' => $courtTypes,
        ]);
    }
}
