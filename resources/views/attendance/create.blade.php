{{-- resources/views/attendance/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Crear Asistencia')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('attendance.index') }}" class="hover:text-sigedra-text-dark">Asistencia</a>
    <span class="mx-2">/</span>
    <span>Crear Asistencia</span>
</div>
@endsection

@section('module_title', 'Registro de Asistencia')
@section('module_subtitle', 'Pasa lista para un curso en una fecha específica')

{{-- El formulario envuelve toda la sección de contenido --}}
<form method="POST" action="{{ route('attendance.store') }}" x-data="attendanceForm()">
    @csrf
    <input type="hidden" name="carga_academica_id" value="{{ $cargaAcademica->id }}">
    <input type="hidden" name="fecha" value="{{ $fecha }}">

    @section('header_actions')
    <div class="hidden md:flex gap-3">
        <a href="{{ route('attendance.index') }}">
            <x-secondary-button type="button">Cancelar</x-secondary-button>
        </a>
        <x-primary-button type="submit">
            <i class="ph ph-floppy-disk text-lg"></i>
            <span>Guardar Asistencia</span>
        </x-primary-button>
    </div>
    @endsection

    @section('footer_actions')
    <div class="flex gap-3 w-full">
        <a href="{{ route('attendance.index') }}" class="w-full">
            <x-secondary-button type="button" class="w-full justify-center">Cancelar</x-secondary-button>
        </a>
        <x-primary-button type="submit" class="w-full justify-center">
            <i class="ph ph-floppy-disk text-lg"></i>
            <span>Guardar Asistencia</span>
        </x-primary-button>
    </div>
    @endsection

    @section('content')
    <div class="space-y-6">
        {{-- Información del Curso y Fecha --}}
        <div class="flex flex-col md:flex-row md:items-baseline md:gap-4">
            <h3 class="text-xl font-bold text-sigedra-primary">
                <span class="font-semibold">Curso:</span> {{ $cargaAcademica->materia->nombre }} - {{ $cargaAcademica->grado->nivelAcademico->nombre }}
            </h3>
            <p class="text-base text-sigedra-text-medium">
                <span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
            </p>
        </div>

        {{-- Acciones Secundarias --}}
        <div class="flex justify-end">
            <div class="flex gap-3 w-full md:w-auto">
                <x-secondary-button @click="markAllPresent()" type="button" class="w-full md:w-auto justify-center text-sm" title="Marcar todos como presentes">
                    <i class="ph ph-check-square-offset text-lg"></i>
                    <span class="sm:inline">Todos Presentes</span>
                </x-secondary-button>
            </div>
        </div>

        {{-- Tabla de Estudiantes --}}
        <div class="overflow-x-auto -mx-4 md:mx-0">
            <table class="min-w-full divide-y divide-sigedra-border">
                <thead class="bg-sigedra-light-bg">
                <tr>
                    <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">#</th>
                    <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Cédula</th>
                    <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]">Nombre completo</th>
                    <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[25%]">Asistencia</th>
                    <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[25%]">Observaciones</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-sigedra-border bg-white">
                @forelse ($students as $student)
                <tr>
                    <td class="px-6 py-3 text-base font-medium text-sigedra-text-dark">{{ $loop->iteration }}</td>
                    <td class="px-6 py-3 text-base text-sigedra-text-dark">{{ $student->cedula }}</td>
                    <td class="px-6 py-3 text-base text-sigedra-text-dark font-medium">{{ $student->nombre_completo }}</td>
                    <td class="px-6 py-3 text-base text-sigedra-text-dark">
                        {{-- Componente de selección de estado de asistencia --}}
                        <div x-data="{ status: 1 }" class="flex items-center gap-1">
                            <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="1" id="presente-{{ $student->id }}" x-model.number="status" class="hidden" checked>
                            <label for="presente-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-sm font-medium rounded-md border" :class="{
                                    'bg-green-100 text-green-800 border-green-300': status == 1,
                                    'bg-white hover:bg-gray-50 text-gray-700': status != 1
                                }">Presente</label>

                            <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="3" id="tardia-{{ $student->id }}" x-model.number="status" class="hidden">
                            <label for="tardia-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-sm font-medium rounded-md border" :class="{
                                    'bg-yellow-100 text-yellow-800 border-yellow-300': status == 3,
                                    'bg-white hover:bg-gray-50 text-gray-700': status != 3
                                }">Tardía</label>

                            <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="2" id="ausente-{{ $student->id }}" x-model.number="status" class="hidden">
                            <label for="ausente-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-sm font-medium rounded-md border" :class="{
                                    'bg-red-100 text-red-800 border-red-300': status == 2,
                                    'bg-white hover:bg-gray-50 text-gray-700': status != 2
                                }">Ausente</label>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-base text-sigedra-text-dark">
                        {{-- El campo de observaciones se muestra condicionalmente --}}
                        <div x-data="{ studentStatus: 1 }" @change="studentStatus = $event.target.value">
                            <template x-if="studentStatus != 1">
                                <input type="text" name="asistencias[{{ $student->id }}][observaciones]" class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añada una observación...">
                            </template>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-sm text-sigedra-text-medium">
                        <div class="flex flex-col items-center">
                            <i class="ph ph-user-list text-5xl text-gray-400"></i>
                            <p class="mt-2 font-semibold">No hay estudiantes en esta clase.</p>
                            <p class="text-xs">No se encontraron estudiantes matriculados en este curso.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection

</form>

@push('scripts')
<script>
    function attendanceForm() {
        return {
            markAllPresent() {
                const presentButtons = document.querySelectorAll('input[type="radio"][value="1"]');
                presentButtons.forEach(button => {
                    button.checked = true;
                    // Dispara un evento 'change' para que Alpine.js actualice la UI
                    button.dispatchEvent(new Event('change', { bubbles: true }));
                });
            }
        }
    }
</script>
@endpush
