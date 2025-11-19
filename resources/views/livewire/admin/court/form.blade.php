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
                    <div class="flex flex-col gap-3.5">
                        <label class="inline-flex items-center cursor-pointer pt-6">
                            <span class="select-none mr-3 text-sm font-medium text-heading">Disponible</span>
                            <input type="checkbox" wire:model.defer="form.disponible" class="sr-only peer">
                            <div
                                class="relative w-9 h-5 
                                bg-gray-300                
                                peer-focus:outline-none 
                                rounded-full transition-all duration-300
                                peer-checked:bg-gray-800
                                after:content-[''] after:absolute after:top-[2px] after:start-[2px]
                                after:w-4 after:h-4 after:bg-white after:rounded-full after:transition-all
                                peer-checked:after:translate-x-full">
                            </div>
                        </label>
                        @error('form.disponible')
                            <div class="flex items-start gap-2 mt-2 text-red-500 text-sm font-medium">
                                <!-- Icono -->
                                <svg class="shrink-0 [:where(&)]:size-5 inline" data-flux-icon
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd"
                                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                        clip-rule="evenodd">
                                    </path>
                                </svg>
                                <!-- Mensaje de error -->
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>
                    {{-- <flux:field variant="inline">
                        <flux:label>Disponible</flux:label>
    
                        <flux:switch wire:model.defer="form.disponible" />
    
                        <flux:error name="form.disponible" />
                    </flux:field> --}}
                </div>
            </div>
            <div class="flex items-center gap-3 mt-10">
                <flux:button variant="primary" type="submit" class="cursor-pointer">{{ $buttonText }}</flux:button>
                <flux:button :href="route('admin.courts.index')" wire:navigate>Cancelar </flux:button>
            </div>
        </form>
    </div>
</div>
