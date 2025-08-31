<div x-data="{ open: false, title: '', message: '', id: null, action: null }"
    x-on:open-confirm.window="
        open = true;
        title = $event.detail.title;
        message = $event.detail.message;
        id = $event.detail.id;
        action = $event.detail.action;
    "
    x-show="open" 
    x-on:click.self="open = false"
    x-on:keydown.esc.window="open = false"
    class="fixed inset-0 flex items-center justify-center z-50 bg-black/30 backdrop-blur-sm" style="display: none;">            

    <div x-show="open" 
    x-transition:enter="transition ease-out duration-200 delay-100 motion-reduce:transition-opacity" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md overflow-hidden">
        <div class="flex flex-col items-center">
            <div class="flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50 h-12 w-12">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="h-6 w-6 text-red-600 dark:text-red-400">
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </div>
            <h2 class="font-semibold text-lg text-gray-800 mt-4 text-center" x-text="title"></h2>
            <p class="mt-2 text-gray-600 text-sm text-center" x-text="message"></p>
        </div>

        <div class="mt-6 flex justify-center gap-2">
            <button @click="open = false"
                class="cursor-pointer px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                Cancelar
            </button>

            <button x-on:click="
                Livewire.dispatch(action, { id: id });
                open = false;
                "
                class="cursor-pointer px-6 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                Confirmar
            </button>
        </div>
    </div>
</div>


