<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js'></script> --}}
    <script src="{{ asset('js/fullcalendar/index.global.min.js') }}"></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- 'resources/js/pages/calendar.js' --}}
</head>

<body class="bg-gray-50 container mx-auto">
    <header class="mt-5 flex justify-between items-center text-blue-500">
        <a class="flex items-center gap-1" href="/">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-ball-football">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M12 7l4.76 3.45l-1.76 5.55h-6l-1.76 -5.55z" />
                <path d="M12 7v-4m3 13l2.5 3m-.74 -8.55l3.74 -1.45m-11.44 7.05l-2.56 2.95m.74 -8.55l-3.74 -1.45" />
            </svg>
            <span class="font-semibold">Reserva de Canchas Deportivas</span>
        </a>
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        {{ __('Log in') }}
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                            {{ __('Register') }}
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>
    <main class="mt-10">
        <!-- INICIO: TÍTULO Y LEYENDA -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            {{-- CAMBIO: H1 rellenado --}}
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-0">
                Calendario de Reservas
            </h1>
            
            {{-- CAMBIO: Leyenda añadida --}}
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    {{-- Usamos bg-amber-500 que equivale a #f59e0b --}}
                    <span class="w-4 h-4 rounded-full bg-amber-500 block"></span>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pendiente</span>
                </div>
                <div class="flex items-center">
                    {{-- Usamos bg-emerald-500 que equivale a #10b981 --}}
                    <span class="w-4 h-4 rounded-full bg-emerald-500 block"></span>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Confirmada</span>
                </div>
                <div class="flex items-center">
                    {{-- Usamos bg-blue-500 que equivale a #3b82f6 --}}
                    <span class="w-4 h-4 rounded-full bg-blue-500 block"></span>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Completada</span>
                </div>
            </div>
        </div>
        <!-- FIN: TÍTULO Y LEYENDA -->
        <div id='calendar' class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md"></div>
    </main>

    <!-- INICIO: FOOTER CON DETALLE DE ESTADOS -->
    <footer class="mt-12 mb-6 p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 text-center">
            Entendiendo los Estados de Reserva
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Estado Pendiente -->
            <div class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-amber-500 block mt-1"></span>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pendiente</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Reserva temporal a la espera de confirmación o pago. Si no se confirma en 10 minutos, se cancelará automáticamente para liberar el horario.
                    </p>
                </div>
            </div>

            <!-- Estado Confirmada -->
            <div class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-500 block mt-1"></span>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Confirmada</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        ¡Reserva exitosa! El pago ha sido recibido y tu horario está 100% asegurado. Esta es tu reserva activa.
                    </p>
                </div>
            </div>

            <!-- Estado Completada -->
            <div class="flex items-start">
                <span class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-500 block mt-1"></span>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Completada</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        Esta reserva ya ha finalizado. Aparece en el calendario como parte de tu historial de juegos.
                    </p>
                </div>
            </div>

        </div>
        <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-6 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Reserva de Canchas Deportivas.
            </p>
        </div>
    </footer>
    <!-- FIN: FOOTER -->

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                timeZone: 'America/Lima',
                initialView: 'timeGridWeek',
                events: '/api/reservations',

                editable: true,
                selectable: true,
                select: function(info) {
                    console.log(info);

                },
            });
            calendar.render();
        });
    </script>
</body>

</html>
