@extends('layouts.app')

@section('title', 'Asistencia')
@section('module_title', 'Seleccionar Curso y Fecha')

@section('content')
<div class="card" x-data="{ subject: 'Matemáticas Avanzadas', date: '' }">
    <div class="card-body">
        <div class="space-y-6">
            <p class="text-sigedra-text-medium">
                Por favor, selecciona la materia y la fecha para pasar lista.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Selector de Materia --}}
                <div>
                    <x-input-label for="subject" value="Materia" />
                    <select id="subject" name="subject" x-model="subject" class="mt-1 block w-full py-2 px-3 border border-sigedra-border bg-white rounded-md shadow-sm focus:outline-none focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm">
                        <option>Matemáticas Avanzadas</option>
                        <option>Ciencias Naturales</option>
                        <option>Historia</option>
                    </select>
                </div>

                {{-- Selector de Fecha --}}
                <div>
                    <x-input-label for="date" value="Fecha" />
                    <x-text-input id="date" class="block mt-1 w-full" type="text" name="date" x-model="date" placeholder="dd/mm/yyyy" required />
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <x-buttons.primary
                    as="button"
                    x-on:click="window.location.href = `{{ route('attendance.create') }}?materia=${subject}&fecha=${date}`"
                >
                    Continuar
                </x-buttons.primary>
            </div>
        </div>
    </div>
</div>
@endsection
