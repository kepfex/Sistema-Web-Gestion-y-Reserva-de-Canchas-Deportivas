<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.schedules.index')" wire:navigate>Horarios
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
                <flux:select wire:model="form.court_id" placeholder="Elije una Cancha..." :label="__('Cancha')"
                    badge=" * ">
                    @forelse ($courts as $court)
                        <flux:select.option value="{{ $court->id }}">{{ $court->nombre }}
                        </flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay canchas</flux:select.option>
                    @endforelse
                </flux:select>

                <flux:select wire:model="form.dia_de_la_semana" placeholder="Elije un día..."
                    :label="__('Día de la Semana')" badge=" * ">
                    @foreach (['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'] as $day)
                        <flux:select.option value="{{ $day }}">{{ ucfirst($day) }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="mt-5 w-full max-w-lg flex gap-4 mb-6">
                <div class="w-40">
                    <flux:input wire:model="form.hora_apertura" :label="__('Hora de Apertura')" type="time"
                        :placeholder="__('ej. 09:00')" badge=" * " />
                </div>

                <div class="w-40">
                    <flux:input wire:model="form.hora_cierre" :label="__('Hora de Cierre')" type="time"
                        :placeholder="__('ej. 17:00')" badge=" * " />
                </div>
            </div>

            <div class="flex items-center gap-3 mt-10">
                <flux:button variant="primary" type="submit" class="cursor-pointer">{{ $buttonText }}</flux:button>
                <flux:button :href="route('admin.schedules.index')" wire:navigate>Cancelar </flux:button>
            </div>
        </form>
    </div>
</div>
