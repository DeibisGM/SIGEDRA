<!-- Componente de tabla reutilizable. -->
<div class="flex flex-col">
    <div class="md:border md:rounded-lg">
        {{-- CAMBIO CLAVE: Se agrega 'table-fixed' --}}
        <table class="min-w-full md:divide-y table-fixed">
            <thead class="bg-sigedra-medium-bg hidden md:table-header-group">
            <!-- El contenido del encabezado de la tabla se inserta aquí -->
            {{ $head }}
            </thead>
            <tbody class="md:divide-y bg-sigedra-bg" wire:loading.class.delay.long="opacity-75" wire:target="applyFilters, clearFilters, nextPage, previousPage, gotoPage">
            <!-- El contenido del cuerpo de la tabla se inserta aquí -->
            {{ $body }}
            </tbody>
        </table>
    </div>
</div>
