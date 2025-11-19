<section x-data="appearanceComponent(@entangle('form.appearance'))" x-init="init()" class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Apariencia')" :subheading="__('Actualice la configuración de apariencia de su cuenta')">
        <h3 class="sr-only">Appearance</h3>

        <ul class="select-none grid w-full gap-4 md:grid-cols-3">
                <!-- LIGHT (Original) -->
                <li>
                    <!-- peer: Usado para referenciar el input desde el label -->
                    <input type="radio" id="original-light" name="appearance-original" value="light" x-model="appearance" class="hidden peer">
                    <label for="original-light"
                        :class="appearance === 'light' ? 'border-blue-600 bg-blue-50 text-blue-800' : 'bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 dark:text-gray-300 text-gray-700'"
                        class="inline-flex items-center justify-between w-full p-4 text-body border rounded-lg cursor-pointer transition duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-start gap-3">
                            <!-- Icono Sol -->
                            <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M6.76 4.84l-1.8-1.79L3.17 4.84l1.79 1.79 1.8-1.79zM1 13h3v-2H1v2zm10 8h2v-3h-2v3zm7.03-3.03l1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM17 11a6 6 0 11-12 0 6 6 0 0112 0zm-1.24-7.16l1.79-1.79L17.24 1.2l-1.79 1.79 1.79 1.85zM21 11h3v-2h-3v2zM4.24 19.76l1.79 1.79 1.41-1.41-1.79-1.79-1.41 1.41z" />
                            </svg>
                            <div>
                                <div class="font-medium">Claro</div>
                            </div>
                        </div>
                    </label>
                </li>

                <!-- DARK (Original) -->
                <li>
                    <input type="radio" id="original-dark" name="appearance-original" value="dark" x-model="appearance" class="hidden peer">
                    <label for="original-dark"
                        :class="appearance === 'dark' ? 'border-blue-600 bg-blue-50 text-blue-800' : 'bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 dark:text-gray-300 text-gray-700'"
                        class="inline-flex items-center justify-between w-full p-4 text-body border rounded-lg cursor-pointer transition duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-start gap-3">
                            <!-- Icono Luna -->
                            <svg class="w-6 h-6 text-indigo-700 dark:text-indigo-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                            </svg>
                            <div>
                                <div class="font-medium">Oscuro</div>
                            </div>
                        </div>
                    </label>
                </li>

                <!-- SYSTEM (Original) -->
                <li>
                    <input type="radio" id="original-system" name="appearance-original" value="system" x-model="appearance" class="hidden peer">
                    <label for="original-system"
                        :class="appearance === 'system' ? 'border-blue-600 bg-blue-50 text-blue-800' : 'bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 dark:text-gray-300 text-gray-700'"
                        class="inline-flex items-center justify-between w-full p-4 text-body border rounded-lg cursor-pointer transition duration-300 shadow-sm hover:shadow-md">
                        <div class="flex items-start gap-3">
                            <!-- Icono Sistema -->
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v11a1 1 0 01-1 1h-6v2h2v1H8v-1h2v-2H4a1 1 0 01-1-1V4z" />
                            </svg>
                            <div>
                                <div class="font-medium">Sistema</div>
                            </div>
                        </div>
                    </label>
                </li>
            </ul>
    </x-settings.layout>
</section>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('appearanceComponent', (entangled) => ({
            // entangled is a Livewire entangle proxy
            appearance: entangled, // this keeps Alpine <> Livewire in sync automatically

            prefersDarkMq: window.matchMedia('(prefers-color-scheme: dark)'),

            init() {
                // aplicar el modo inicial inmediatamente
                this.applyTheme(this.appearance);

                // si seleccionan system, escuchar cambios en preferencia del OS
                this.prefersDarkMq.addEventListener('change', (e) => {
                    if (this.appearance === 'system') {
                        this.applyTheme('system');
                    }
                });

                // Si Alpine cambia appearance, entangle actualizará Livewire automáticamente.
                this.$watch('appearance', (val) => {
                    this.applyTheme(val);
                });
            },

            applyTheme(value) {
                const el = document.documentElement;
                if (value === 'light') {
                    el.classList.remove('dark');
                } else if (value === 'dark') {
                    el.classList.add('dark');
                } else { // system
                    if (this.prefersDarkMq.matches) {
                        el.classList.add('dark');
                    } else {
                        el.classList.remove('dark');
                    }
                }
            }
        }))
    })
</script>
