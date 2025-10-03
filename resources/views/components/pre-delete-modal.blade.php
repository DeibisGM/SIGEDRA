<x-modal :name="$name" focusable>
    {{-- 1. Añade un x-data para manejar la ruta dinámica y ESCUCHA el evento --}}
    <div class="p-6" x-data="{ dynamicAction: '' }" x-on:set-maestro-action.window="dynamicAction = $event.detail.url" class="p-6">

        <h2 class="text-lg font-medium text-sigedra-text-dark">
            {{ $title ?? '¿Estás seguro de que quieres eliminar este elemento?' }}
        </h2>

        <p class="mt-1 text-base text-sigedra-text-medium">
            {{ $text ?? '¿Estás seguro de que quieres eliminar este elemento?' }}
        </p>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancelar
            </x-secondary-button>

            <form x-bind:action="dynamicAction" method="POST" class="ml-2">
                @csrf
                @method('DELETE')

                <x-primary-button class="hover:bg-[#FB584B]">
                    Eliminar
                </x-primary-button>
            </form>
        </div>
    </div>
</x-modal>
