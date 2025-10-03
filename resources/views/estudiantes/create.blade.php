@extends('layouts.app')

@section('title', 'Crear Estudiante')

@section('breadcrumbs')
<div class="text-sm text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('estudiantes.index') }}" class="hover:text-gray-700">Estudiantes</a>
    <span class="mx-2">/</span>
    <span>Crear Nuevo Estudiante</span>
</div>
@endsection

@section('module_title', 'Crear Nuevo Estudiante')
@section('module_subtitle', 'Ingresa los datos para registrar un nuevo estudiante en el sistema.')

@section('content')
<div class="w-full">
    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium">Hay errores en el formulario:</h3>
                    <ul class="mt-2 text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('estudiantes.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- 1. Card: Información de Identidad --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Información de Identidad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Tipo de Identificación --}}
                <div>
                    <x-input-label for="tipo_identificacion" value="Tipo de Identificación" />
                    <select id="tipo_identificacion" name="tipo_identificacion" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="nacional" selected>Nacional</option>
                        <option value="extranjero">Extranjero</option>
                    </select>
                </div>

                {{-- Cédula --}}
                <div class="md:col-span-2">
                    <x-input-label for="cedula" value="Cédula *" />
                    <x-text-input
                        id="cedula"
                        name="cedula"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        placeholder="Ej: 1-2345-6789"
                        value="{{ old('cedula') }}" />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- 2. Card: Datos Personales --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Datos Personales</h2>

            {{-- Nombre y Apellidos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                {{-- Primer Nombre --}}
                <div>
                    <x-input-label for="primer_nombre" value="Primer Nombre *" />
                    <x-text-input
                        id="primer_nombre"
                        name="primer_nombre"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        placeholder="Juan"
                        value="{{ old('primer_nombre') }}" />
                    <x-input-error :messages="$errors->get('primer_nombre')" class="mt-2" />
                </div>

                {{-- Segundo Nombre --}}
                <div>
                    <x-input-label for="segundo_nombre" value="Segundo Nombre" />
                    <x-text-input
                        id="segundo_nombre"
                        name="segundo_nombre"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Carlos"
                        value="{{ old('segundo_nombre') }}" />
                </div>

                {{-- Primer Apellido --}}
                <div>
                    <x-input-label for="primer_apellido" value="Primer Apellido *" />
                    <x-text-input
                        id="primer_apellido"
                        name="primer_apellido"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        placeholder="Pérez"
                        value="{{ old('primer_apellido') }}" />
                    <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
                </div>

                {{-- Segundo Apellido --}}
                <div>
                    <x-input-label for="segundo_apellido" value="Segundo Apellido" />
                    <x-text-input
                        id="segundo_apellido"
                        name="segundo_apellido"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Rojas"
                        value="{{ old('segundo_apellido') }}" />
                </div>
            </div>

            {{-- Fecha de Nacimiento, Género y Nacionalidad --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end mt-6">
                {{-- Fecha de Nacimiento --}}
                <div>
                    <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento *" />
                    <x-text-input
                        id="fecha_nacimiento"
                        name="fecha_nacimiento"
                        type="date"
                        class="mt-1 block w-full"
                        required
                        value="{{ old('fecha_nacimiento') }}" />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>

                {{-- Género --}}
                <div>
                    <x-input-label for="genero" value="Género *" />
                    <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Seleccione...</option>
                        <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="O" {{ old('genero') == 'O' ? 'selected' : '' }}>Otro</option>
                    </select>
                    <x-input-error :messages="$errors->get('genero')" class="mt-2" />
                </div>

                {{-- Nacionalidad --}}
                <div>
                    <x-input-label for="nacionalidad" value="Nacionalidad" />
                    <x-text-input
                        id="nacionalidad"
                        name="nacionalidad"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Ej: Costarricense"
                        value="{{ old('nacionalidad', 'Costarricense') }}" />
                </div>
            </div>

            {{-- Apartado de Dirección --}}
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Dirección</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Provincia --}}
                    <div>
                        <x-input-label for="provincia" value="Provincia" />
                        <x-text-input
                            id="provincia"
                            name="provincia"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Ej: San José"
                            value="{{ old('provincia') }}" />
                    </div>
                    {{-- Cantón --}}
                    <div>
                        <x-input-label for="canton" value="Cantón" />
                        <x-text-input
                            id="canton"
                            name="canton"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Ej: Desamparados"
                            value="{{ old('canton') }}" />
                    </div>
                    {{-- Distrito --}}
                    <div>
                        <x-input-label for="distrito" value="Distrito" />
                        <x-text-input
                            id="distrito"
                            name="distrito"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Ej: San Miguel"
                            value="{{ old('distrito') }}" />
                    </div>
                    {{-- Dirección Exacta --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-input-label for="direccion_exacta" value="Dirección Exacta" />
                        <textarea
                            id="direccion_exacta"
                            name="direccion_exacta"
                            rows="3"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            placeholder="Ej: 100 metros al sur del parque central, casa color verde con portón negro.">{{ old('direccion_exacta') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Card: Información Académica --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Información Académica</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="grado_id" value="Grado a Matricular *" />
                    <select
                        id="grado_id"
                        name="grado_id"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required>
                        <option value="" disabled {{ old('grado_id') ? '' : 'selected' }}>Seleccione un grado...</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado->id }}" {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                                {{ $grado->nivelAcademico->nombre }} - {{ $grado->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('grado_id')" class="mt-2" />
                </div>
            </div>
        </div>

        {{-- 4. Card: Adecuaciones Curriculares --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Adecuaciones Curriculares</h2>

            {{-- Checkbox para mostrar/ocultar campos de adecuación --}}
            <div class="relative flex items-start mb-6">
                <div class="flex items-center h-5">
                    <input
                        id="tiene_adecuacion"
                        name="tiene_adecuacion"
                        type="checkbox"
                        class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                        value="1"
                        {{ old('tiene_adecuacion') ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                    <label for="tiene_adecuacion" class="font-medium text-gray-800">Este estudiante requiere adecuación curricular</label>
                    <p class="text-gray-500">Marque esta casilla si el estudiante necesita una adecuación curricular.</p>
                </div>
            </div>

            {{-- Campos de adecuación (ocultos por defecto) --}}
            <div id="adecuacion_fields" class="space-y-6" style="display: {{ old('tiene_adecuacion') ? 'block' : 'none' }};">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tipo de Adecuación --}}
                    <div>
                        <x-input-label for="adecuacion_id" value="Tipo de Adecuación *" />
                        <select
                            id="adecuacion_id"
                            name="adecuacion_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Seleccione una adecuación...</option>
                            @foreach($adecuaciones as $adecuacion)
                                <option value="{{ $adecuacion->id }}" {{ old('adecuacion_id') == $adecuacion->id ? 'selected' : '' }}>
                                    {{ $adecuacion->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('adecuacion_id')" class="mt-2" />
                    </div>

                    {{-- Nivel de Adecuación --}}
                    <div>
                        <x-input-label for="nivel_adecuacion" value="Nivel de Adecuación *" />
                        <select
                            id="nivel_adecuacion"
                            name="nivel_adecuacion"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Seleccione el nivel...</option>
                            <option value="Significativa" {{ old('nivel_adecuacion') == 'Significativa' ? 'selected' : '' }}>Significativa</option>
                            <option value="No Significativa" {{ old('nivel_adecuacion') == 'No Significativa' ? 'selected' : '' }}>No Significativa</option>
                            <option value="De Acceso" {{ old('nivel_adecuacion') == 'De Acceso' ? 'selected' : '' }}>De Acceso</option>
                        </select>
                        <x-input-error :messages="$errors->get('nivel_adecuacion')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Fecha de Asignación --}}
                    <div>
                        <x-input-label for="fecha_asignacion_adecuacion" value="Fecha de Asignación *" />
                        <x-text-input
                            id="fecha_asignacion_adecuacion"
                            name="fecha_asignacion_adecuacion"
                            type="date"
                            class="mt-1 block w-full"
                            value="{{ old('fecha_asignacion_adecuacion', date('Y-m-d')) }}" />
                        <x-input-error :messages="$errors->get('fecha_asignacion_adecuacion')" class="mt-2" />
                    </div>

                    {{-- Estado de la Adecuación --}}
                    <div class="flex items-end">
                        <div class="relative flex items-start pb-1">
                            <div class="flex items-center h-5">
                                <input
                                    id="adecuacion_activa"
                                    name="adecuacion_activa"
                                    type="checkbox"
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                    value="1"
                                    {{ old('adecuacion_activa', true) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="adecuacion_activa" class="font-medium text-gray-800">Adecuación Activa</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Card: Estado del Estudiante --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Estado</h2>
            <div class="space-y-4">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input
                            id="activo"
                            name="activo"
                            type="checkbox"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            value="1"
                            {{ old('activo', true) ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="activo" class="font-medium text-gray-800">Estudiante Activo</label>
                        <p class="text-gray-500">Por defecto, el estudiante se registrará como activo en el sistema.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="flex items-center justify-end gap-3 bg-white border border-gray-200 rounded-lg p-6">
            <x-secondary-button type="button" onclick="window.location='{{ route('estudiantes.index') }}'">
                Cancelar
            </x-secondary-button>

            <x-primary-button type="submit">
                <i class="ph ph-plus-circle text-lg"></i>
                <span>Guardar Estudiante</span>
            </x-primary-button>
        </div>
    </form>
</div>

<script>
    function toggleAdecuacionFields() {
        const checkbox = document.getElementById('tiene_adecuacion');
        const fields = document.getElementById('adecuacion_fields');
        const adecuacionId = document.getElementById('adecuacion_id');
        const nivelAdecuacion = document.getElementById('nivel_adecuacion');
        const fechaAsignacion = document.getElementById('fecha_asignacion_adecuacion');

        if (checkbox.checked) {
            fields.style.display = 'block';
            adecuacionId.required = true;
            nivelAdecuacion.required = true;
            fechaAsignacion.required = true;
        } else {
            fields.style.display = 'none';
            adecuacionId.required = false;
            nivelAdecuacion.required = false;
            fechaAsignacion.required = false;
            adecuacionId.value = '';
            nivelAdecuacion.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('tiene_adecuacion');
        checkbox.addEventListener('change', toggleAdecuacionFields);
        toggleAdecuacionFields(); // Ejecutar al cargar
    });
</script>

@endsection
