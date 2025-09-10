<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.courts.index')" wire:navigate>Canchas Deportivas
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $breadcrumbsText }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="mb-6 mt-4">
        <h1 class="text-3xl font-black dark:text-white">{{ $title }}</h1>
    </div>

    <div class="flex-1 self-stretch max-md:pt-6">
        <form wire:submit.prevent='save' class="my-6 w-full space-y-6">
            @csrf

            <div class="mt-5 w-full max-w-lg flex flex-col gap-4 mb-4">
                {{-- Campo para el Tipo de Cancha --}}
                <flux:select wire:model="form.court_type_id" placeholder="Elije un Tipo de Cancha..."
                    :label="__('Tipos de Canchas')" badge=" * ">
                    @forelse ($courtTypes as $courtType)
                        <flux:select.option value="{{ $courtType->id }}">{{ $courtType->nombre }}</flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay tipos de canchas disponibles</flux:select.option>
                    @endforelse
                </flux:select>
            </div>
            <div class="mt-5 w-full max-w-lg flex flex-col gap-4 mb-4">
                <flux:input wire:model.defer="form.nombre" :label="__('Nombre de la Cancha')" type="text"
                    :placeholder="__('ej. Cancha 1 - Césped')" badge=" * "/>
            </div>
            <div class="mt-5 w-full max-w-lg flex flex-col gap-4 mb-4">
                {{-- Campo para las Medidas --}}
                <flux:input wire:model.defer="form.medidas" :label="__('Medidas')" type="text"
                    :placeholder="__('Ej. 20m x 40m')" />
            </div>

            <div class="mt-5 w-full max-w-lg flex flex-col gap-4 mb-4">
                {{-- Campo para la Ubicación --}}
                <flux:input wire:model.defer="form.ubicacion" :label="__('Ubicación')" type="text"
                    :placeholder="__('Ej. Cancha 1, al fondo del complejo')" />
            </div>

            <div class="mt-5 max-w-lg flex flex-col gap-4 mb-4">
                {{-- Campo para el estado de Disponibilidad --}}
                <div class="flex items-center gap-2">
                    <flux:field variant="inline">
                        <flux:label>Disponible</flux:label>
    
                        <flux:switch wire:model.defer="form.disponible" />
    
                        <flux:error name="form.disponible" />
                    </flux:field>
                </div>
            </div>
            <div class="flex items-center gap-3 mt-10">
                <flux:button variant="primary" type="submit" class="cursor-pointer">{{ $buttonText }}</flux:button>
                <flux:button :href="route('admin.courts.index')" wire:navigate>Cancelar </flux:button>
            </div>
        </form>
    </div>
</div>
