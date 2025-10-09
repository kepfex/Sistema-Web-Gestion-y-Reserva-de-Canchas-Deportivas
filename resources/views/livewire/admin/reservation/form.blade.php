<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item :href="route('admin.reservations.index')" wire:navigate>Reservaciones
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
                <!-- Campo para el Usuario -->
                <flux:select wire:model="form.user_id" placeholder="Elije un Usuario..." :label="__('Usuario')"
                    badge=" * ">
                    @forelse ($users as $user)
                        <flux:select.option value="{{ $user->id }}">{{ $user->name }}
                        </flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay usuarios</flux:select.option>
                    @endforelse
                </flux:select>

                <!-- Campo para la Cancha -->
                <flux:select wire:model="form.court_id" placeholder="Elije una Cancha..." :label="__('Cancha')"
                    badge=" * ">
                    @forelse ($courts as $court)
                        <flux:select.option value="{{ $court->id }}">{{ $court->nombre }}
                        </flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay canchas</flux:select.option>
                    @endforelse
                </flux:select>
            </div>

            <div class="mt-5 w-full max-w-lg flex flex-col gap-4 mb-6">
                <flux:input wire:model="form.fecha_hora_inicio" :label="__('Fecha y Hora de Inicio')"
                    type="datetime-local" badge=" * " />

                <flux:input wire:model="form.fecha_hora_fin" :label="__('Fecha y Hora de Fin')"
                    type="datetime-local" badge=" * " />

                <!-- Campo para el Estado -->
                <flux:select wire:model="form.estado" placeholder="Elije un Estado..." :label="__('Estado')" badge=" * ">
                    <flux:select.option value="pendiente">Pendiente</flux:select.option>
                    <flux:select.option value="confirmada">Confirmada</flux:select.option>
                    <flux:select.option value="cancelada">Cancelada</flux:select.option>
                    <flux:select.option value="completada">Completada</flux:select.option>
                </flux:select>
            </div>

            <div class="flex items-center gap-3 mt-10">
                <flux:button variant="primary" type="submit" class="cursor-pointer">{{ $buttonText }}</flux:button>
                <flux:button :href="route('admin.reservations.index')" wire:navigate>Cancelar</flux:button>
            </div>
        </form>
    </div>
</div>
