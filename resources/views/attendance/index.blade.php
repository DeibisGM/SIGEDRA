@extends('layouts.app')

@section('title', 'Asistencia')

@section('breadcrumbs')
    <div class="text-base text-gray-500 whitespace-nowrap truncate">
        <a href="{{ route('attendance.index') }}" class="hover:text-gray-700">Asistencia</a>
        <span class="mx-2">/</span>
        <span>Historial de asistencia</span>
    </div>
@endsection

@section('module_title', 'Historial de Asistencias')
@section('module_subtitle', 'Consulta el historial de las asistencias en el sistema')

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
    @livewire('gestion-asistencias')

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
    <x-modal name="pre-create-modal" focusable x-cloak style="display: none;">
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
