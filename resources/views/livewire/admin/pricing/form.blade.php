<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.pricings.index')" wire:navigate>Precios
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $breadcrumbsText }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="mb-6 mt-4">
        <h1 class="text-3xl font-black dark:text-white">{{ $title }}</h1>
    </div>

    <div class="flex-1 self-stretch max-md:pt-6">
        <form wire:submit.prevent='save' class="my-6 w-full space-y-6">
            @csrf

            <div class="mt-5 w-full max-w-lg flex flex-col gap-4 mb-6">
                <flux:select wire:model="form.court_type_id" placeholder="Elije un Tipo de Cancha..."
                    :label="__('Tipos de Canchas')" badge=" * ">
                    @forelse ($courtTypes as $courtType)
                        <flux:select.option value="{{ $courtType->id }}">{{ $courtType->nombre }}
                        </flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay tipos de canchas</flux:select.option>
                    @endforelse
                </flux:select>
            </div>

            <div class="mt-5 w-full max-w-lg flex gap-4 mb-6">
                <div class="w-30">
                    <flux:input wire:model="form.hora_inicio" :label="__('Hora de Inicio')" type="time"
                        :placeholder="__('ej. 09:00')" badge=" * " />
                </div>

                <div class="w-30">
                    <flux:input wire:model="form.hora_fin" :label="__('Hora Fin')" type="time"
                        :placeholder="__('ej. 17:00')" badge=" * " />
                </div>
            </div>

            <div class="mt-5 w-full max-w-lg flex flex-col md:flex-row gap-4 mb-6">
                <div class="max-w-1/2">
                    <flux:input wire:model.defer="form.precio_por_hora" :label="__('Precio por Hora S/.')" type="number"
                        step="0.01" min="0" :placeholder="__('ej. 15.50')" badge=" * " />
                </div>
                {{-- Campo para el Switch de Precio Nocturno --}}
                <div class="flex items-center">
                    <flux:field variant="inline" class="pt-6">
                        <flux:label>Precio Nocturno</flux:label>
                        <flux:switch wire:model.defer="form.es_precio_nocturno" />
                        <flux:error name="form.es_precio_nocturno" />
                    </flux:field>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-10">
                <flux:button variant="primary" type="submit" class="cursor-pointer">{{ $buttonText }}</flux:button>
                <flux:button :href="route('admin.pricings.index')" wire:navigate>Cancelar </flux:button>
            </div>
        </form>
    </div>
</div>
