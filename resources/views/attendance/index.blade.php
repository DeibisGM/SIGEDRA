@extends('layouts.app')

@section('title', 'Asistencia')
@section('module_title', 'Asistencia')

@section('content')
<div class="space-y-8">
    <!-- Sub-encabezado y Acciones Principales -->
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 p-4 bg-white border border-sigedra-border rounded-lg">
        <div>
            <!-- Títulos con la nueva jerarquía de CSS -->
            <h2 class="text-xl text-sigedra-primary">Registro de Asistencia</h2>
            <p class="mt-1 text-base text-sigedra-text-medium">Curso: <span class="font-semibold">Matemáticas Avanzadas</span> &bull; 10/09/2025</p>
        </div>
        <div class="flex gap-3">
            <x-buttons.secondary>Cancelar</x-buttons.secondary>
            <x-buttons.primary>
                <i class="ph ph-floppy-disk text-lg"></i>
                <span>Guardar Cambios</span>
            </x-buttons.primary>
        </div>
    </div>

    <!-- Barra de Búsqueda y Acciones Secundarias -->
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-2/5">
            <input type="text" class="py-3 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar estudiante...">
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
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Comentarios</th>
            </tr>
        </x-slot:head>

        {{-- Slot para el cuerpo de la tabla --}}
        <x-slot:body>
            @forelse ($students as $student)
            <tr class="odd:bg-white even:bg-sigedra-input/40 hover:bg-sigedra-primary/10">
                <td class="px-6 py-3 whitespace-nowrap text-base text-sigedra-text-medium">{{ $loop->iteration }}</td>
                <td class="px-6 py-3 whitespace-nowrap text-base text-sigedra-text-medium">{{ $student['cedula'] }}</td>
                <td class="px-6 py-3 whitespace-nowrap text-base font-medium text-sigedra-text-dark">{{ $student['nombre'] }}</td>
                <td class="px-6 py-3 whitespace-nowrap"><x-percentage-chip :percentage="$student['asistencia']" /></td>
                <td class="px-6 py-3 whitespace-nowrap w-48">
                    <select class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-base text-sigedra-text-dark focus:border-sigedra-primary focus:ring-sigedra-primary">
                        <option>Presente</option>
                        <option>Ausente</option>
                        <option>Justificado</option>
                        <option>Tardía</option>
                    </select>
                </td>
                <td class="px-6 py-3 whitespace-nowrap">
                    <input type="text" class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añadir comentario...">
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-3 text-center text-base text-sigedra-text-medium">No hay estudiantes en esta clase.</td>
            </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>
@endsection
