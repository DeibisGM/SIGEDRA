@extends('layouts.app')

@section('title', 'Asistencia')
@section('module_title', 'Asistencia')

@section('content')
<div class="space-y-6">
    <!-- Sub-encabezado y Acciones Principales -->
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 p-4 bg-white border border-sigedra-border rounded-lg">
        <div>
            <h2 class="text-lg font-bold text-sigedra-text-dark">Registro de Asistencia</h2>
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
            <input type="text" class="py-3 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-medium focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar estudiante...">
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

    <!-- Tabla de Estudiantes -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="border rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-sigedra-border">
                        <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-sigedra-text-medium uppercase tracking-wider">Cédula</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-sigedra-text-medium uppercase tracking-wider">Nombre completo</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-sigedra-text-medium uppercase tracking-wider">Asistencia</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-sigedra-text-medium uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-sigedra-text-medium uppercase tracking-wider">Comentarios</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-sigedra-border">
                        @forelse ($students as $student)
                        <tr class="odd:bg-white even:bg-sigedra-input/40 hover:bg-sigedra-primary/10">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-medium">{{ $student['cedula'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-sigedra-text-dark">{{ $student['nombre'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-sigedra-primary">{{ $student['asistencia'] }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm w-48">
                                <select class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-sm text-sigedra-text-dark focus:border-sigedra-primary focus:ring-sigedra-primary">
                                    <option>Presente</option>
                                    <option>Ausente</option>
                                    <option>Justificado</option>
                                    <option>Tardía</option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <input type="text" class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-sm text-sigedra-text-dark placeholder-sigedra-text-medium focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añadir comentario...">
                            </td>
                        </tr>
                        @empty
                        <tr class="odd:bg-white">
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-sigedra-text-medium">No hay estudiantes en esta clase.</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
