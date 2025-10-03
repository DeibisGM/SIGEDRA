<x-modal :name="$name" focusable>
    <div x-data="{ formId: '{{ $formId }}' }" class="p-6">

        <h2 class="text-lg font-medium text-sigedra-text-dark">
            {{ $title ?? 'Confirmar Actualización' }}
        </h2>

        <p class="mt-1 text-base text-sigedra-text-medium">
            {{ $text ?? 'Al confirmar, se guardarán todos los cambios realizados en este formulario.' }}
        </p>

        <div class="mt-6 flex justify-end gap-2">
            <x-secondary-button x-on:click="$dispatch('close')">
                Cancelar
            </x-secondary-button>

            <x-primary-button as="button" class="ml-2"
                x-on:click="$dispatch('close');
                   document.getElementById(formId).submit();">
                Confirmar y Guardar
            </x-primary-button>
        </div>
    </div>
</x-modal>
