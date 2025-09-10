<?php

namespace App\Livewire\Admin\Pricing;

use App\Livewire\Forms\Admin\PricingForm;
use App\Models\CourtType;
use App\Models\Pricing;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Editar - Precio'])]
class Edit extends Component
{
    public PricingForm $form;
    public Pricing $pricing;

    public function mount(Pricing $pricing)
    {
        $this->pricing = $pricing;
        $this->form->setPricing($pricing);
    }

    public function save()
    {
        $this->form->update();

         // Prepara los datos para el toast
        $notification = [
            'variant' => 'success',
            'title'   => '¡Actualizado!',
            'message' => 'El Precio se actuzalizó correctamente.'
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
            'breadcrumbsText' => 'Editar',
            'title' => 'Editar Precio',
            'buttonText' => 'Guardar Cambios',
            'courtTypes' => $courtTypes,
        ]);
    }
}
