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

    @if (session('success'))
    <x-flash-message type="success" :message="session('success')" />
    @endif

    @if (session('error'))
    <x-flash-message type="error" :message="session('error')" />
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
                    <x-input-label for="cedula" value="Cédula*" />
                    <x-text-input
                        id="cedula"
                        name="cedula"
                        type="text"
                        maxlength="20"
                        class="mt-1 block w-full @error('cedula') @enderror"
                        autofocus
                        placeholder="Ej: 123456789"
                        value="{{ old('cedula') }}" />

                    @error('cedula')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 2. Card: Datos Personales --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Datos Personales</h2>

            {{-- Nombre y Apellidos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-start">
                {{-- Primer Nombre --}}
                <div>
                    <x-input-label for="primer_nombre" value="Primer Nombre*" />
                    <x-text-input
                        id="primer_nombre"
                        name="primer_nombre"
                        type="text"
                        maxlength="100"
                        class="mt-1 block w-full @error('primer_nombre') @enderror"
                        placeholder="Ej: Juan"
                        value="{{ old('primer_nombre') }}" />

                    @error('primer_nombre')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Segundo Nombre --}}
                <div>
                    <x-input-label for="segundo_nombre" value="Segundo Nombre" />
                    <x-text-input
                        id="segundo_nombre"
                        name="segundo_nombre"
                        type="text"
                        maxlength="100"
                        class="mt-1 block w-full @error('segundo_nombre') @enderror"
                        placeholder="Ej: Carlos"
                        value="{{ old('segundo_nombre') }}" />

                    @error('segundo_nombre')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Primer Apellido --}}
                <div>
                    <x-input-label for="primer_apellido" value="Primer Apellido*" />
                    <x-text-input
                        id="primer_apellido"
                        name="primer_apellido"
                        type="text"
                        maxlength="100"
                        class="mt-1 block w-full @error('primer_apellido') @enderror"
                        placeholder="Ej: Pérez"
                        value="{{ old('primer_apellido') }}" />

                    @error('primer_apellido')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Segundo Apellido --}}
                <div>
                    <x-input-label for="segundo_apellido" value="Segundo Apellido" />
                    <x-text-input
                        id="segundo_apellido"
                        name="segundo_apellido"
                        type="text"
                        maxlength="100"
                        class="mt-1 block w-full @error('segundo_apellido') @enderror"
                        placeholder="Ej: Rojas"
                        value="{{ old('segundo_apellido') }}" />

                    @error('segundo_apellido')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Fecha de Nacimiento, Género y Nacionalidad --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start mt-6">
                {{-- Fecha de Nacimiento --}}
                <div>
                    <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento*" />
                    <x-text-input
                        id="fecha_nacimiento"
                        name="fecha_nacimiento"
                        type="date"
                        class="mt-1 block w-full @error('fecha_nacimiento') @enderror"
                        value="{{ old('fecha_nacimiento') }}" />

                    @error('fecha_nacimiento')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Género --}}
                <div>
                    <x-input-label for="genero" value="Género*" />
                    <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('genero') @enderror">
                        <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Seleccione...</option>
                        <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                        <option value="O" {{ old('genero') == 'O' ? 'selected' : '' }}>Otro</option>
                    </select>

                    @error('genero')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nacionalidad --}}
                <div>
                    <x-input-label for="nacionalidad" value="Nacionalidad" />
                    <x-text-input
                        id="nacionalidad"
                        name="nacionalidad"
                        type="text"
                        maxlength="100"
                        class="mt-1 block w-full @error('nacionalidad') @enderror"
                        placeholder="Ej: Costarricense"
                        value="{{ old('nacionalidad', 'Costarricense') }}" />

                    @error('nacionalidad')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
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
                            maxlength="100"
                            class="mt-1 block w-full @error('provincia') @enderror"
                            placeholder="Ej: San José"
                            value="{{ old('provincia') }}" />

                        @error('provincia')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Cantón --}}
                    <div>
                        <x-input-label for="canton" value="Cantón" />
                        <x-text-input
                            id="canton"
                            name="canton"
                            type="text"
                            maxlength="100"
                            class="mt-1 block w-full @error('canton') @enderror"
                            placeholder="Ej: Desamparados"
                            value="{{ old('canton') }}" />

                        @error('canton')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Distrito --}}
                    <div>
                        <x-input-label for="distrito" value="Distrito" />
                        <x-text-input
                            id="distrito"
                            name="distrito"
                            type="text"
                            maxlength="100"
                            class="mt-1 block w-full @error('distrito') @enderror"
                            placeholder="Ej: San Miguel"
                            value="{{ old('distrito') }}" />

                        @error('distrito')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Dirección Exacta --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-input-label for="direccion_exacta" value="Dirección Exacta" />
                        <textarea
                            id="direccion_exacta"
                            name="direccion_exacta"
                            rows="3"
                            maxlength="500"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('direccion_exacta') @enderror"
                            placeholder="Ej: 100 metros al sur del parque central, casa color verde con portón negro.">{{ old('direccion_exacta') }}</textarea>

                        @error('direccion_exacta')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Card: Información Académica --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Información Académica</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="grado_id" value="Grado a Matricular*" />
                    <select
                        id="grado_id"
                        name="grado_id"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('grado_id') @enderror">
                        <option value="" disabled {{ old('grado_id') ? '' : 'selected' }}>Seleccione un grado...</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado->id }}" {{ old('grado_id') == $grado->id ? 'selected' : '' }}>
                                {{ $grado->nivelAcademico->nombre }} - {{ $grado->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('grado_id')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
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
                        <x-input-label for="adecuacion_id" value="Tipo de Adecuación*" />
                        <select
                            id="adecuacion_id"
                            name="adecuacion_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('adecuacion_id') @enderror">
                            <option value="">Seleccione una adecuación...</option>
                            @foreach($adecuaciones as $adecuacion)
                                <option value="{{ $adecuacion->id }}" {{ old('adecuacion_id') == $adecuacion->id ? 'selected' : '' }}>
                                    {{ $adecuacion->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('adecuacion_id')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nivel de Adecuación --}}
                    <div>
                        <x-input-label for="nivel_adecuacion" value="Nivel de Adecuación*" />
                        <select
                            id="nivel_adecuacion"
                            name="nivel_adecuacion"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('nivel_adecuacion') @enderror">
                            <option value="">Seleccione el nivel...</option>
                            <option value="Significativa" {{ old('nivel_adecuacion') == 'Significativa' ? 'selected' : '' }}>Significativa</option>
                            <option value="No Significativa" {{ old('nivel_adecuacion') == 'No Significativa' ? 'selected' : '' }}>No Significativa</option>
                            <option value="De Acceso" {{ old('nivel_adecuacion') == 'De Acceso' ? 'selected' : '' }}>De Acceso</option>
                        </select>

                        @error('nivel_adecuacion')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Fecha de Asignación --}}
                    <div>
                        <x-input-label for="fecha_asignacion_adecuacion" value="Fecha de Asignación*" />
                        <x-text-input
                            id="fecha_asignacion_adecuacion"
                            name="fecha_asignacion_adecuacion"
                            type="date"
                            class="mt-1 block w-full @error('fecha_asignacion_adecuacion') @enderror"
                            value="{{ old('fecha_asignacion_adecuacion', date('Y-m-d')) }}" />

                        @error('fecha_asignacion_adecuacion')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
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

        if (checkbox.checked) {
            fields.style.display = 'block';
        } else {
            fields.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('tiene_adecuacion');
        checkbox.addEventListener('change', toggleAdecuacionFields);
        toggleAdecuacionFields();
    });
</script>

@endsection
