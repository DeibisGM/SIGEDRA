@extends('layouts.app')

@section('title', 'Asistencia')
@section('module_title', 'Historial de Asistencias')

@section('header_actions')
    <div class="hidden md:flex">
        <x-buttons.primary
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
        >
            <i class="ph ph-plus-circle text-lg"></i>
            <span>Pasar Nueva Asistencia</span>
        </x-buttons.primary>
    </div>
@endsection

@section('footer_actions')
    <x-buttons.primary
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
        class="w-full md:hidden"
    >
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



    <x-table class="-mx-4 md:mx-0 table-fixed w-full">
        <x-slot:head>
            <tr>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[100px]">Fecha</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Curso</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Presentes</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Ausentes</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Tardías</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Asistencia %</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[220px]">Acciones</th>
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
            @php
            $total = $attendance['present'] + $attendance['absent'] + $attendance['late'];
            $percent = $total > 0 ? round(($attendance['present'] / $total) * 100) : 0;
            @endphp
            <tr class="border-b border-sigedra-border">
                <td class="px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['date'] }}</td>
                <td class="px-6 py-4 font-medium text-sigedra-text-dark">{{ $attendance['course'] }}</td>
                <td class="px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['present'] }}</td>
                <td class="px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['absent'] }}</td>
                <td class="px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['late'] }}</td>
                <td class="px-6 py-4 text-base text-sigedra-text-medium">{{ $percent }}%</td>
                <td class="px-6 py-4 text-base font-medium">
                    <div class="flex items-center space-x-2">
                        <x-buttons.secondary href="#">
                            <i class="ph ph-eye"></i>

                        </x-buttons.secondary>
                        <x-buttons.secondary href="#">
                            <i class="ph ph-pencil-simple"></i>

                        </x-buttons.secondary>
                        <x-buttons.danger-secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-attendance-deletion')">
                            <i class="ph ph-trash"></i>

                        </x-buttons.danger-secondary>
                    </div>
                </td>
            </tr>
            @endforeach
        </x-slot:body>
    </x-table>


    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-attendance-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                ¿Estás seguro de que deseas eliminar este registro de asistencia?
            </h2>

            <p class="mt-1 text-base text-gray-600">
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

    <!-- Pre-create Modal -->
    <x-modal name="pre-create-modal" focusable>
        <div class="p-6" x-data="{ subject: 'Matemáticas Avanzadas', date: '' }">
            <h2 class="text-lg font-medium text-gray-900">
                Seleccionar Curso y Fecha
            </h2>

            <p class="mt-1 text-base text-gray-600">
                Por favor, selecciona la materia y la fecha para pasar lista.
            </p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Selector de Materia -->
                <div>
                    <x-input-label for="subject" value="Materia" />
                    <select id="subject" name="subject" x-model="subject" class="mt-1 block w-full py-2 px-3 border border-sigedra-border bg-white rounded-md shadow-sm focus:outline-none focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm">
                        <option>Matemáticas Avanzadas</option>
                        <option>Ciencias Naturales</option>
                        <option>Historia</option>
                    </select>
                </div>

                <!-- Selector de Fecha -->
                <div>
                    <x-input-label for="date" value="Fecha" />
                    <x-text-input id="date" class="block mt-1 w-full flatpickr" type="text" name="date" x-model="date" placeholder="dd/mm/yyyy" required />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-buttons.secondary x-on:click="$dispatch('close')">
                    Cancelar
                </x-buttons.secondary>

                <x-buttons.primary
                    as="button"
                    x-on:click="window.location.href = `{{ route('attendance.create') }}?materia=${subject}&fecha=${date}`"
                >
                    Continuar
                </x-buttons.primary>
            </div>
        </div>
    </x-modal>
</div>
@endsection
