<!--
Componente de tabla reutilizable.
Usa slots para el contenido del encabezado (head) y el cuerpo (body).
-->
<div class="flex flex-col">
    <div class="overflow-hidden border border-sigedra-border rounded-lg">
        <table class="min-w-full">
            <thead class="bg-sigedra-input border-b border-sigedra-border hidden md:table-header-group">
            <!-- El contenido del encabezado de la tabla se inserta aquí -->
            {{ $head }}
            </thead>
            <tbody class="divide-y divide-sigedra-border">
            <!-- El contenido del cuerpo de la tabla se inserta aquí -->
            {{ $body }}
            </tbody>
        </table>
    </div>
</div>
