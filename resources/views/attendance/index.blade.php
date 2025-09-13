@extends('layouts.app')

@section('title', 'Asistencia')
@section('module_title', 'Registro de Asistencia')

@section('header_actions')
    <div class="flex gap-3">
        <x-buttons.secondary>Cancelar</x-buttons.secondary>
        <x-buttons.primary>
            <i class="ph ph-floppy-disk text-lg"></i>
            <span>Guardar Cambios</span>
        </x-buttons.primary>
    </div>
@endsection

@section('content')
<div class="space-y-8">
    <div class="flex items-baseline gap-4">
        <!-- Títulos con la nueva jerarquía de CSS -->
        <h3 class="text-xl">Primer Grado</h3>
        <p class="text-base text-sigedra-text-medium">Curso: <span class="font-semibold">Matemáticas Avanzadas</span> &bull; 10/09/2025</p>
    </div>

    <!-- Barra de Búsqueda y Acciones Secundarias -->
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-2/5">
            <input type="text" class="py-2 px-4 ps-11 block w-full bg-white border rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar estudiante...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
        <div class="flex gap-3">
            <x-buttons.secondary>
                <i class="ph ph-arrows-clockwise text-lg"></i>
                <span>Actualizar</span>
            </x-buttons.secondary>
            <x-buttons.secondary>Marcar todos como presentes</x-buttons.secondary>
        </div>
    </div>

    <!-- Tabla de Estudiantes implementada con el nuevo componente reutilizable -->
    <x-table>
        {{-- Slot para el encabezado de la tabla --}}
        <x-slot:head>
            <tr>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Cédula</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Nombre completo</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Asistencia</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Estado</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Observaciones</th>
            </tr>
        </x-slot:head>

        {{-- Slot para el cuerpo de la tabla --}}
        <x-slot:body>
            @forelse ($students as $student)
                <x-tarjeta-alumno :student="$student" :loop="$loop" />
            @empty
            <tr>
                <td colspan="6" class="px-6 py-3 text-center text-base text-sigedra-text-medium">No hay estudiantes en esta clase.</td>
            </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>
@endsection
