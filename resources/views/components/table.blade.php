<!--
Componente de tabla reutilizable.
Usa slots para el contenido del encabezado (head) y el cuerpo (body).
-->
<div class="flex flex-col">
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="border rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-sigedra-border">
                    <thead class="bg-sigedra-input">
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
    </div>
</div>
