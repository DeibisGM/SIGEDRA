@extends('layouts.app')

@section('title', 'Gestión de Asistencia')

@section('content')
<div class="space-y-6">
    <!-- Encabezado del Módulo -->
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <div>
            {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño del título principal a text-3xl. --}}
            <h1 class="text-3xl font-bold text-sigedra-text-dark">Asistencia</h1>
            <div class="mt-2 text-sigedra-text-medium">
                <p class="font-bold text-lg text-sigedra-text-dark">Curso: <span class="font-semibold">Matemáticas MM451</span></p>
                {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de la fuente de text-sm a text-base. --}}
                <p class="text-base">Sofia Ramírez - 7-1 - 2025 - Lunes 9-10am / Martes 11-12pm</p>
            </div>
        </div>
        <div class="relative">
            {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de la fuente a text-base. --}}
            <input type="text" class="py-2.5 px-4 w-48 bg-white border border-sigedra-border rounded-lg text-base text-sigedra-text-dark focus:border-sigedra-primary focus:ring-sigedra-primary" value="05/07/2025">
             <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-3.5">
                 <svg class="flex-shrink-0 h-4 w-4 text-sigedra-text-medium" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
            </div>
        </div>
    </div>

    <!-- Barra de Búsqueda y Controles -->
    <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="relative w-full md:w-2/5">
             {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de la fuente a text-base. --}}
             <input type="text" class="py-3 px-4 ps-11 block w-full bg-sigedra-input border-transparent rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-medium focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar estudiante...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <svg class="flex-shrink-0 w-4 h-4 text-sigedra-text-medium" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
        </div>
        <div class="flex gap-3">
            <x-buttons.secondary-button>Actualizar</x-buttons.secondary-button>
            <x-buttons.secondary-button>Marcar todos como presentes</x-buttons.secondary-button>
        </div>
    </div>

    <!-- Tabla de Estudiantes -->
    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle">
            <x-tables.table-container>
                <thead class="bg-sigedra-input/50">
                    <tr>
                         {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de fuente de text-xs a text-sm y se hace más gruesa (font-bold). --}}
                         <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Cédula</th>
                        <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Nombre completo</th>
                        <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Comentarios</th>
                        <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Grado</th>
                        <th scope="col" class="px-6 py-3 text-start text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Asistencia</th>
                        <th scope="col" class="px-6 py-3 text-center text-sm font-bold text-sigedra-text-medium uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sigedra-border bg-white">
                    @forelse ($students as $student)
                        <tr class="hover:bg-sigedra-input/40">
                            {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de la fuente del cuerpo de la tabla de text-sm a text-base. --}}
                            <td class="px-6 py-4 whitespace-nowrap text-base text-sigedra-text-medium">{{ $student['cedula'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-sigedra-text-dark">{{ $student['nombre'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-sigedra-text-medium">
                                <textarea class="py-2 px-3 block w-full bg-sigedra-input border-transparent rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-medium focus:border-sigedra-primary focus:ring-sigedra-primary" rows="1" placeholder="Añadir comentario..."></textarea>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-base text-sigedra-text-medium">{{ explode('-', $student['seccion'])[0] }}º</td>
                            <td class="px-6 py-4 whitespace-nowrap text-base font-medium text-sigedra-primary">{{ $student['asistencia'] }}%</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-base font-medium">
                                <select class="py-2 px-3 block w-full bg-sigedra-input border-transparent rounded-lg text-base text-sigedra-text-dark focus:border-sigedra-primary focus:ring-sigedra-primary">
                                    <option selected disabled value="">Seleccionar...</option>
                                    <option value="presente">Presente</option>
                                    <option value="ausente">Ausente</option>
                                    <option value="justificado">Justificado</option>
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-base text-sigedra-text-medium">No hay estudiantes en esta clase.</td>
                        </tr>
                    @endforelse
                </tbody>
            </x-tables.table-container>
        </div>
    </div>
</div>

<!-- Footer de Acciones Fijo -->
<div class="fixed bottom-0 left-0 w-full bg-white border-t border-sigedra-border z-30">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
        {{-- CAMBIO DE ACCESIBILIDAD: Se aumenta el tamaño de fuente de text-xs a text-sm. --}}
        <p class="text-sm text-sigedra-text-medium hidden md:block">
            Última actualización: 08:46:30 p. m. &nbsp;&bull;&nbsp; Sesión iniciada: 08:46:17 p. m.
        </p>
        <div class="flex gap-3 w-full md:w-auto justify-end">
            <x-buttons.secondary-button>Cancelar</x-buttons.secondary-button>
            <x-buttons.primary-button>Guardar</x-buttons.primary-button>
        </div>
    </div>
</div>
@endsection
