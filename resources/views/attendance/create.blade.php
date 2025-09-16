@extends('layouts.app')

@section('title', 'Asistencia')

@section('breadcrumbs')
    <div class="text-base text-gray-500 whitespace-nowrap truncate">
        <a href="{{ route('attendance.index') }}" class="hover:text-gray-700">Asistencia</a>
        <span class="mx-2">/</span>
        <span>Crear Asistencia</span>
    </div>
@endsection

@section('module_title', 'Registro de Asistencia')
@section('module_subtitle', 'Pasa lista para un curso en una fecha específica')

@section('header_actions')
    <div class="hidden md:flex gap-3">
        <x-buttons.secondary>Cancelar</x-buttons.secondary>
        <x-buttons.primary>
            <i class="ph ph-floppy-disk text-lg"></i>
            <span>Guardar Cambios</span>
        </x-buttons.primary>
    </div>
@endsection

@section('footer_actions')
    <div class="flex gap-3 w-full">
        <x-buttons.secondary class="w-full justify-center">Cancelar</x-buttons.secondary>
        <x-buttons.primary class="w-full justify-center">
            <i class="ph ph-floppy-disk text-lg"></i>
            <span>Guardar Cambios</span>
        </x-buttons.primary>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-baseline md:gap-4">
        <h3 class="text-xl font-bold text-sigedra-primary">
            <span class="font-semibold">Curso:</span> {{ $subject }}
        </h3>
        <p class="text-base text-sigedra-text-medium">
            <span class="font-semibold">Fecha:</span> {{ $date }}
        </p>
    </div>

    <!-- Barra de Búsqueda y Acciones Secundarias -->
    <div class="flex flex-col md:flex-row gap-3 justify-between items-center">
        {{-- Search bar --}}
        <div class="relative w-full md:w-auto md:flex-1">
            <input type="text" class="py-2 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar estudiante...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
        {{-- Action buttons --}}
        <div class="flex gap-3 w-full md:w-auto justify-end">
            <x-buttons.secondary class="w-full md:w-auto justify-center text-sm" title="Actualizar">
                <i class="ph ph-arrows-clockwise text-lg"></i>
                <span class="sm:inline">Actualizar</span>
            </x-buttons.secondary>
            <x-buttons.secondary class="w-full md:w-auto justify-center text-sm" title="Marcar todos como presentes">
                <i class="ph ph-check-square-offset text-lg"></i>
                <span class="sm:inline">Todos presentes</span>
            </x-buttons.secondary>
        </div>
    </div>

    <!-- Tabla de Estudiantes implementada con el nuevo componente reutilizable -->
    <x-table class="-mx-4 md:mx-0">
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
                <td colspan="6" class="px-6 py-3 text-center text-sm text-sigedra-text-medium">No hay estudiantes en esta clase.</td>
            </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>
@endsection
