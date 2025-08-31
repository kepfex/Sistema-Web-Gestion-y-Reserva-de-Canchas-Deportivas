{{--
Recibimos las siguientes props:
- $colspan: (int) Número de columnas a ocupar.
- $search: (string|null) Término de búsqueda.
- $title: (string) Nombre de la entidad.
- $createUrl: (string) URL para el botón de creación.
--}}

<td colspan="{{ $colspan }}">
    <div class="text-center px-6 py-12">
        {{-- Icono --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" 
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
            stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M4 6c0 1.657 3.582 3 8 3s8 -1.343 8 -3s-3.582 -3 -8 -3s-8 1.343 -8 3" />
            <path d="M4 6v6c0 1.657 3.582 3 8 3m8 -3.5v-5.5" />
            <path d="M4 12v6c0 1.657 3.582 3 8 3s8 -1.343 8 -3v-6" />
            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
            <path d="M20.2 20.2l1.8 1.8" />
        </svg>

        @if ($search)
            {{-- Mensaje cuando la búsqueda no encuentra nada --}}
            <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white">
                No se encontraron resultados
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                No pudimos encontrar nada que coincida con "<strong class="font-medium">{{ $search }}</strong>".
            </p>
        @else
            {{-- Mensaje cuando la tabla está vacía --}}
            <h3 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white">
                Aún no hay {{ Str::plural($title) }}
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                ¡Comienza creando el primer registro!
            </p>
            {{-- Botón de llamada a la acción --}}
            <a wire:navigate href="{{ $createUrl }}"
                class="mt-6 px-5 py-2 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 me-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" /><path d="M5 12l14 0" />
                </svg>
                Crear {{ $title }}
            </a>
        @endif
    </div>
</td>