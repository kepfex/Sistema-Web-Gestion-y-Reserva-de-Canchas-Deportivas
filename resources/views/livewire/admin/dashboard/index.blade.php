@php
    // 1. OBTENER DATOS 
    $datos = $this->reservasPorEstadoHoy(); 

    // 2. DEFINIR LA CONFIGURACIÓN VISUAL (Mapeo)
    // Aquí definimos el "Look & Feel" para cada estado posible.
    $estadosConfig = [
        'pendiente' => [
            'titulo' => 'Pendientes',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
            // Colores definidos explícitamente para que Tailwind no los purgue
            'borde' => 'border-amber-500',
            'texto_num' => 'text-amber-600 dark:text-amber-400',
            'bg_icon' => 'bg-amber-50 dark:bg-amber-900/30',
            'text_icon' => 'text-amber-500',
            'badge_bg' => 'bg-amber-100 dark:bg-amber-900/40',
            'badge_text' => 'text-amber-600 dark:text-amber-400',
            'mensaje' => 'Requiere acción'
        ],
        'confirmada' => [
            'titulo' => 'Confirmadas',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'borde' => 'border-emerald-500',
            'texto_num' => 'text-emerald-600 dark:text-emerald-400',
            'bg_icon' => 'bg-emerald-50 dark:bg-emerald-900/30',
            'text_icon' => 'text-emerald-500',
            'badge_bg' => 'bg-emerald-100 dark:bg-emerald-900/40',
            'badge_text' => 'text-emerald-600 dark:text-emerald-400',
            'mensaje' => 'Próximos juegos'
        ],
        'completada' => [
            'titulo' => 'Completadas',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />',
            'borde' => 'border-blue-500',
            'texto_num' => 'text-blue-600 dark:text-blue-400',
            'bg_icon' => 'bg-blue-50 dark:bg-blue-900/30',
            'text_icon' => 'text-blue-500',
            'badge_bg' => 'bg-blue-100 dark:bg-blue-900/40',
            'badge_text' => 'text-blue-600 dark:text-blue-400',
            'mensaje' => 'Historial'
        ],
        'cancelada' => [
            'titulo' => 'Canceladas',
            'icono' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'borde' => 'border-rose-500',
            'texto_num' => 'text-rose-600 dark:text-rose-400',
            'bg_icon' => 'bg-rose-50 dark:bg-rose-900/30',
            'text_icon' => 'text-rose-500',
            'badge_bg' => 'bg-rose-100 dark:bg-rose-900/40',
            'badge_text' => 'text-rose-600 dark:text-rose-400',
            'mensaje' => 'Anuladas'
        ]
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    
    @foreach($estadosConfig as $key => $estilo)
        @php
            // Obtenemos el valor numérico, si no existe ponemos 0
            $cantidad = $datos[$key] ?? 0;
        @endphp

        <!-- Tarjeta Dinámica -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden group hover:shadow-md transition-all duration-300">
            
            <!-- Barra lateral de color -->
            <div class="absolute right-0 top-0 h-full w-1 {{ str_replace('border-', 'bg-', $estilo['borde']) }}"></div>
            
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        {{ $estilo['titulo'] }}
                    </p>
                    <h3 class="text-4xl font-bold mt-2 text-gray-900 dark:text-white">
                        {{ $cantidad }}
                    </h3>
                </div>
                
                <!-- Icono con fondo dinámico -->
                <div class="p-3 rounded-xl {{ $estilo['bg_icon'] }} {{ $estilo['text_icon'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $estilo['icono'] !!}
                    </svg>
                </div>
            </div>

            <!-- Badge inferior -->
            <div class="mt-4">
                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $estilo['badge_bg'] }} {{ $estilo['badge_text'] }}">
                    {{ $estilo['mensaje'] }}
                </span>
            </div>
        </div>
    @endforeach

</div>