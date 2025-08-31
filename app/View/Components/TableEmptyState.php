<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableEmptyState extends Component
{
    /**
     * Create a new component instance.
     */
    /**
     * Crea una nueva instancia del componente.
     */
    public function __construct(
        public int $colspan,
        public ?string $search = null,
        public string $title,
        public string $createUrl
    ) {
        // Las propiedades públicas se pasan automáticamente a la vista
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-empty-state');
    }
}
