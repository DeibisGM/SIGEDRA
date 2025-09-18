@props(['student'])

{{-- CAMBIO: Se añade un div contenedor con menos espaciado vertical (space-y-4) --}}
<div class="space-y-4">
    <!-- Card de Datos Personales -->
    <div class="bg-white border border-sigedra-border rounded-lg p-6">
        <h3 class="text-xl font-semibold border-b border-sigedra-border pb-4 mb-6">Datos Personales</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">

            <div>
                <dt class="text-sm font-semibold text-sigedra-text-medium">Fecha de Nacimiento</dt>
                <dd class="mt-1 text-base text-sigedra-text-dark">{{ \Carbon\Carbon::parse($student['fecha_nacimiento'])->translatedFormat('d \d\e F \d\e Y') }}</dd>
            </div>

            <x-details-field label="Edad" value="{{ $student['edad'] }} años" />
            <x-details-field label="Género" value="{{ $student['genero'] }}" />
            <x-details-field label="Nacionalidad" value="{{ $student['nacionalidad'] }}" />
            <x-details-field label="Dirección" value="{{ $student['direccion'] }}" class="md:col-span-2" />
        </dl>
    </div>

    <!-- Card de Información del Encargado -->
    <div class="bg-white border border-sigedra-border rounded-lg p-6">
        <h3 class="text-xl font-semibold border-b border-sigedra-border pb-4 mb-6">Información del Encargado</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6">
            <x-details-field label="Nombre" value="{{ $student['encargado']['nombre'] }}" />
            <x-details-field label="Teléfono" value="{{ $student['encargado']['telefono'] }}" />
            <x-details-field label="Correo Electrónico" value="{{ $student['encargado']['email'] }}" />
        </dl>
    </div>

    <!-- Card de Adecuación Curricular -->
    <div class="bg-white border border-sigedra-border rounded-lg p-6">
        <h3 class="text-xl font-semibold border-b border-sigedra-border pb-4 mb-6">Adecuación Curricular</h3>
        @if($student['adecuacion']['requiere'])
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <x-details-field label="Tipo de Adecuación" value="{{ $student['adecuacion']['tipo'] }}" />
            <div class="md:col-span-2">
                <dt class="text-sm font-semibold text-sigedra-text-medium">Detalles y Observaciones</dt>
                <dd class="mt-1 text-base text-sigedra-text-dark prose max-w-none">
                    <p>{{ $student['adecuacion']['detalles'] }}</p>
                </dd>
            </div>
        </dl>
        @else
        <p class="text-gray-600">El estudiante no tiene registrada ninguna adecuación curricular.</p>
        @endif
    </div>
</div>
