<!--
Componente de tabla reutilizable.
Usa slots para el contenido del encabezado (head) y el cuerpo (body).
-->
<div class="flex flex-col">
    <div class="md:border md:rounded-lg">
        <table class="min-w-full md:divide-y">
            <thead class="bg-sigedra-input hidden md:table-header-group">
            <!-- El contenido del encabezado de la tabla se inserta aquí -->
            {{ $head }}
            </thead>
            <tbody class="md:divide-y divide-sigedra-border" wire:loading.class.delay.long="opacity-75" wire:target="applyFilters, clearFilters, nextPage, previousPage, gotoPage">
            <!-- El contenido del cuerpo de la tabla se inserta aquí -->
            {{ $body }}
            </tbody>
        </table>
    </div>
</div>
