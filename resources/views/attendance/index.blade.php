@extends('layouts.app')

@section('title', 'Asistencia')

@section('content')
<div class="space-y-6">
    <!-- Encabezado del Módulo y Controles -->
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-sigedra-text-dark">Asistencia</h1>
            <p class="mt-2 text-base text-sigedra-text-medium">Curso: <span class="font-semibold">Matemáticas Avanzadas</span> &bull; 10/09/2025</p>
        </div>
        <div class="flex gap-3">
            <x-buttons.secondary>
                <i class="ph ph-arrows-clockwise text-lg"></i>
                <span>Actualizar</span>
            </x-buttons.secondary>
            <x-buttons.primary>
                <i class="ph ph-floppy-disk text-lg"></i>
                <span>Guardar Cambios</span>
            </x-buttons.primary>
        </div>
    </div>

    <!-- Barra de Búsqueda y Filtros -->
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-2/5">
            <input type="text" class="py-3 px-4 ps-11 block w-full bg-sigedra-input border-transparent rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-medium focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar estudiante por nombre o cédula...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
        <x-buttons.secondary>Marcar todos como presentes</x-buttons.secondary>
    </div>

    <!-- Tabla de Estudiantes -->
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <x-tables.table-container>
                <thead class="bg-sigedra-input/50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Cédula</th>
                    <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Nombre completo</th>
                    <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Estado</th>
                    <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Comentarios</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-sigedra-border bg-white">
                @forelse ($students as $student)
                <tr class="hover:bg-sigedra-input/40">
                    <td class="px-6 py-4 whitespace-nowrap text-base text-sigedra-text-medium">{{ $student['cedula'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-sigedra-text-dark">{{ $student['nombre'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium w-48">
                        <select class="py-2 px-3 block w-full bg-sigedra-input border-transparent rounded-lg text-base text-sigedra-text-dark focus:border-sigedra-primary focus:ring-sigedra-primary">
                            <option>Presente</option>
                            <option>Ausente</option>
                            <option>Justificado</option>
                            <option>Tardía</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-base text-sigedra-text-medium">
                        <input type="text" class="py-2 px-3 block w-full bg-sigedra-input border-transparent rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-medium focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añadir comentario...">
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-base text-sigedra-text-medium">No hay estudiantes en esta clase.</td>
                </tr>
                @endforelse
                </tbody>
            </x-tables.table-container>
        </div>
    </div>
</div>
@endsection
