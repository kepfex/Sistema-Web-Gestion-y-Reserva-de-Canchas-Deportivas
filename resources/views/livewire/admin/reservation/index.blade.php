<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate>{{ __('Dashboard') }}
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item>{{ $titulo }}
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <div class="flex justify-between items-center mb-6 mt-4">
        <h1 class="text-3xl font-black dark:text-white">{{ $titulo }}</h1>
        <a wire:navigate href="{{ route('admin.reservations.create') }}"
            class="px-5 py-2 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="w-5 h-5 me-2 icon icon-tabler icons-tabler-outline icon-tabler-clock-plus">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M20.984 12.535a9 9 0 1 0 -8.468 8.45" />
                <path d="M16 19h6" />
                <path d="M19 16v6" />
                <path d="M12 7v5l3 3" />
            </svg>
            Nueva Reserva
        </a>
    </div>

    <div class="flex justify-between items-center mb-4">
        <div class="relative flex w-full max-w-20 flex-col gap-1 text-on-surface dark:text-on-surface-dark">
            <label for="os" class="w-fit pl-0.5 text-sm">Por página</label>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                class="absolute pointer-events-none right-4 top-8 size-5">
                <path fill-rule="evenodd"
                    d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
            </svg>
            <select wire:model.live="paginarX"
                class="w-full appearance-none rounded-md border border-outline bg-surface-alt px-4 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
            </select>
        </div>

        <div class="relative flex w-full max-w-xs flex-col gap-1 text-on-surface dark:text-on-surface-dark">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" aria-hidden="true"
                class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-on-surface/50 dark:text-on-surface-dark/50">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
            <input wire:model.live="search" type="search"
                class="w-full rounded-md border border-outline bg-surface-alt py-2 pl-10 pr-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-outline-dark dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark"
                name="search" placeholder="Buscar" aria-label="search" />
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg"> {{-- Inicio Tabla --}}
        <table
            class="w-full table-auto border-collapse text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Usuario
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cancha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de Inicio
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de Fin
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th scope="col" class="px-6 py-3 w-40 text-center">
                        <span class="sr-only">Acciones</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $reservation)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $reservation->id }}
                        </th>
                        <td class="px-6 py-3">
                            {{ $reservation->user->name }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $reservation->court->nombre }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $reservation->fecha_hora_inicio }}
                        </td>
                        <td class="px-6 py-3">
                            {{ $reservation->fecha_hora_fin }}
                        </td>
                        <td class="px-6 py-3">
                            @if ($reservation->estado === 'pendiente')
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                            @elseif ($reservation->estado === 'confirmada')
                                <span
                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Confirmada</span>
                            @elseif ($reservation->estado === 'cancelada')
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Cancelada</span>
                            @elseif ($reservation->estado === 'completada')
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Completada</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right flex space-x-2">
                            <a wire:navigate href="{{ route('admin.reservations.edit', $reservation) }}"
                                class="inline-flex items-center justify-center px-3 py-1 border border-blue-500 rounded-md font-medium text-sm text-blue-500 hover:bg-blue-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="w-4 h-4 mr-1 icon icon-tabler icons-tabler-outline icon-tabler-pencil-minus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                    <path d="M16 19h6" />
                                </svg>
                                <span>Editar</span>
                            </a>
                            <button
                                wire:click="$dispatch('open-confirm', { 
                                title: 'Eliminar Precio', 
                                message: '¿Está segura/o de hacer esto?',  
                                id: {{ $reservation->id }}, 
                                action: 'delete-reservation' 
                            })"
                                type="button"
                                class="cursor-pointer inline-flex items-center justify-center px-3 py-1 border border-red-500 rounded-md font-medium text-sm text-red-500 hover:bg-red-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="w-4 h-4 mr-1 icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                </svg>
                                <span>Eliminar</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <x-table-empty-state :colspan="7" :search="$search" title="{{ $titulo }}"
                            :createUrl="route('admin.reservations.create')" />
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $reservations->links() }}
    </div>

    @if (session('notify'))
        <script>
            // Escucha el evento 'livewire:navigated', que se dispara en cada navegación de Livewire
            document.addEventListener('livewire:navigated', () => {
                // Despacha el evento 'notify' al objeto window para que AlpineJS lo capture
                window.dispatchEvent(
                    new CustomEvent('notify', {
                        detail: @json(session('notify'))
                    })
                );
            }, {
                once: true
            }); // { once: true } asegura que se ejecute solo una vez por navegación
        </script>
    @endif
</div>
