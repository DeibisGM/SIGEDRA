@extends('layouts.app')

@section('title', 'Asistencia')
@section('module_title', 'Historial de Asistencias')

@section('header_actions')
    <div class="hidden md:flex">
        <x-buttons.primary href="{{ route('attendance.pre-create') }}">
            <i class="ph ph-plus-circle text-lg"></i>
            <span>Pasar Nueva Asistencia</span>
        </x-buttons.primary>
    </div>
@endsection

@section('footer_actions')
    <x-buttons.primary href="{{ route('attendance.pre-create') }}" class="w-full md:hidden">
        <i class="ph ph-plus-circle text-lg"></i>
        <span>Pasar Nueva Asistencia</span>
    </x-buttons.primary>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Barra de Búsqueda y Filtros -->
    <div class="flex flex-col md:flex-row gap-3 justify-between items-center">
        <div class="relative w-full md:w-auto md:flex-1">
            <input type="text" class="py-2 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar por fecha o curso...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
        <div class="flex gap-3 w-full md:w-auto justify-end">
            <x-buttons.secondary class="w-full md:w-auto justify-center text-sm" title="Filtros">
                <i class="ph ph-faders text-lg"></i>
                <span class="sm:inline">Filtros</span>
            </x-buttons.secondary>
        </div>
    </div>

    <!-- Tabla de Historial de Asistencias -->
    <x-table class="-mx-4 md:mx-0">
        <x-slot:head>
            <tr>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Fecha</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Curso</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Presentes</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Ausentes</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Tardías</th>
                <th scope="col" class="px-6 py-4 text-end text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Acciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @php
                $attendances = [
                    ['date' => '10/05/2024', 'course' => 'Matemáticas Avanzadas', 'present' => 18, 'absent' => 2, 'late' => 1],
                    ['date' => '09/05/2024', 'course' => 'Matemáticas Avanzadas', 'present' => 20, 'absent' => 0, 'late' => 1],
                    ['date' => '08/05/2024', 'course' => 'Ciencias Naturales', 'present' => 15, 'absent' => 5, 'late' => 0],
                    ['date' => '07/05/2024', 'course' => 'Matemáticas Avanzadas', 'present' => 19, 'absent' => 1, 'late' => 1],
                    ['date' => '06/05/2024', 'course' => 'Historia', 'present' => 21, 'absent' => 0, 'late' => 0],
                ];
            @endphp
            @foreach ($attendances as $attendance)
                <tr class="border-b border-sigedra-border">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-dark font-semibold">{{ $attendance['date'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-medium">{{ $attendance['course'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-medium">{{ $attendance['present'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-medium">{{ $attendance['absent'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-medium">{{ $attendance['late'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                        <div class="flex justify-end gap-2 items-center">
                            <x-buttons.secondary href="#">
                                <i class="ph ph-eye"></i>
                                <span>Ver</span>
                            </x-buttons.secondary>
                            <x-buttons.secondary href="#">
                                <i class="ph ph-pencil-simple"></i>
                                <span>Editar</span>
                            </x-buttons.secondary>
                            <x-buttons.danger-secondary
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-attendance-deletion')"
                            >
                                <i class="ph ph-trash"></i>
                                <span>Eliminar</span>
                            </x-buttons.danger-secondary>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-table>

    <x-modal name="confirm-attendance-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                ¿Estás seguro de que deseas eliminar este registro de asistencia?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Una vez eliminado, no se podrá recuperar.
            </p>

            <div class="mt-6 flex justify-end">
                <x-buttons.secondary x-on:click="$dispatch('close')">
                    Cancelar
                </x-buttons.secondary>

                <x-danger-button class="ms-3" x-on:click="$dispatch('close')">
                    Eliminar
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
@endsection
