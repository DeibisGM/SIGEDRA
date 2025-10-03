@props(['title', 'text'])

<x-modal name="confirm-deletion" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-sigedra-text-dark">
            {{ $title ?? 'Confirmar Eliminación' }}
        </h2>
        <p class="mt-1 text-base text-sigedra-text-medium">
            {{ $text ?? '¿Estás seguro de que deseas realizar esta acción?' }}
        </p>
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close-modal', 'confirm-deletion')">
                Cancelar
            </x-secondary-button>
            <x-danger-button class="ms-3" {{ $attributes->whereStartsWith('wire:click') }} x-on:click="$dispatch('deleting'); $dispatch('close-modal', 'confirm-deletion')">
                Eliminar
            </x-danger-button>
        </div>
    </div>
</x-modal>