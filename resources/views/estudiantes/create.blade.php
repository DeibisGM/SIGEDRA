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
    <form action="#" method="POST" class="space-y-8">
        @csrf

        {{-- Seccion de Datos Personales --}}
        <div class="space-y-6">
            <h2 class="text-lg font-semibold border-b border-gray-200 pb-2">Datos Personales del Estudiante</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <!-- Tipo de Identificacion -->
                <div>
                    <x-input-label for="tipo_identificacion" :value="__('Tipo de Identificación')" />
                    <select id="tipo_identificacion" name="tipo_identificacion" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="nacional">Nacional</option>
                        <option value="extranjero">Extranjero</option>
                    </select>
                </div>

                <!-- Cédula con botón -->
                <div class="md:col-span-1">
                    <x-input-label for="cedula" :value="__('Cédula')" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <x-text-input id="cedula" name="cedula" type="text" class="block w-full rounded-none rounded-l-md" required autofocus placeholder="Buscar estudiante..."/>
                        <button type="button" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                            <span>Buscar</span>
                        </button>
                    </div>
                </div>

                <!-- Nacionalidad -->
                <div>
                    <x-input-label for="nacionalidad" :value="__('Nacionalidad')" />
                    <x-text-input id="nacionalidad" name="nacionalidad" type="text" class="mt-1 block w-full" placeholder="Ej: Costarricense"/>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Primer Nombre -->
                <div>
                    <x-input-label for="primer_nombre" :value="__('Primer Nombre')" />
                    <x-text-input id="primer_nombre" name="primer_nombre" type="text" class="mt-1 block w-full" required placeholder="Juan"/>
                </div>

                <!-- Segundo Nombre -->
                <div>
                    <x-input-label for="segundo_nombre" :value="__('Segundo Nombre (Opcional)')" />
                    <x-text-input id="segundo_nombre" name="segundo_nombre" type="text" class="mt-1 block w-full" placeholder="Carlos"/>
                </div>

                <!-- Primer Apellido -->
                <div>
                    <x-input-label for="primer_apellido" :value="__('Primer Apellido')" />
                    <x-text-input id="primer_apellido" name="primer_apellido" type="text" class="mt-1 block w-full" required placeholder="Pérez"/>
                </div>

                <!-- Segundo Apellido -->
                <div>
                    <x-input-label for="segundo_apellido" :value="__('Segundo Apellido (Opcional)')" />
                    <x-text-input id="segundo_apellido" name="segundo_apellido" type="text" class="mt-1 block w-full" placeholder="Rojas"/>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Fecha de Nacimiento -->
                <div>
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" required />
                </div>

                <!-- Género -->
                <div>
                    <x-input-label for="genero" :value="__('Género')" />
                    <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione un género...</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Seccion de Informacion Academica --}}
        <div class="space-y-6">
            <h2 class="text-lg font-semibold border-b border-gray-200 pb-2">Información Académica</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Grado a Matricular -->
                <div>
                    <x-input-label for="grado_id" :value="__('Grado a Matricular')" />
                    <select id="grado_id" name="grado_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione un grado...</option>
                        <option value="1">Sétimo</option>
                        <option value="2">Octavo</option>
                        <option value="3">Noveno</option>
                        <option value="4">Décimo</option>
                        <option value="5">Undécimo</option>
                        <option value="6">Duodécimo</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Seccion de Adecuacion --}}
        <div class="space-y-6">
            <h2 class="text-lg font-semibold border-b border-gray-200 pb-2">Necesidades Especiales (Adecuación)</h2>
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="necesita_adecuacion" name="necesita_adecuacion" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                </div>
                <div class="ml-3 text-sm">
                    <label for="necesita_adecuacion" class="font-medium text-gray-700">El estudiante requiere adecuación curricular</label>
                    <p class="text-gray-500">Marque esta casilla si el estudiante necesita algún tipo de apoyo o adecuación.</p>
                </div>
            </div>

            <div id="campos_adecuacion" class="hidden space-y-6 mt-4 pl-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipo de Adecuación -->
                    <div>
                        <x-input-label for="adecuacion_id" :value="__('Tipo de Adecuación')" />
                        <select id="adecuacion_id" name="adecuacion_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Seleccione un tipo...</option>
                            <option value="1">No Significativa</option>
                            <option value="2">Significativa</option>
                            <option value="3">De Acceso</option>
                        </select>
                    </div>
                </div>
                <!-- Detalles de la Adecuación -->
                <div>
                    <x-input-label for="adecuacion_detalles" :value="__('Detalles y Observaciones')" />
                    <textarea id="adecuacion_detalles" name="adecuacion_detalles" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Describa las recomendaciones, apoyos y observaciones del especialista..."></textarea>
                </div>
            </div>
        </div>

        {{-- Seccion de Encargado --}}
        <div class="space-y-6">
            <h2 class="text-lg font-semibold border-b border-gray-200 pb-2">Asignación de Encargado</h2>
            <div class="p-4 border-l-4 border-blue-400 bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Aquí podrá buscar un encargado existente por cédula o crear uno nuevo si no se encuentra en el sistema.
                        </p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="encargado_cedula" :value="__('Buscar Encargado por Cédula')" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <x-text-input id="encargado_cedula" name="encargado_cedula" type="text" class="block w-full rounded-none rounded-l-md" placeholder="Cédula del encargado"/>
                        <button type="button" class="relative -ml-px inline-flex items-center space-x-2 rounded-r-md border border-gray-300 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                            <span>Buscar</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm font-medium text-gray-900">Encargados Asignados:</span>
                <div class="mt-2 p-4 bg-gray-50 rounded-md border">
                    <p class="text-sm text-gray-500">Ningún encargado asignado todavía.</p>
                </div>
            </div>
        </div>


        {{-- Botones de Accion --}}
        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
            <x-buttons.secondary as="a" href="{{ route('estudiantes.index') }}">
                Cancelar
            </x-buttons.secondary>

            <x-primary-button class="ms-3">
                Crear Estudiante
            </x-primary-button>
        </div>
    </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const necesitaAdecuacionCheckbox = document.getElementById('necesita_adecuacion');
        const camposAdecuacion = document.getElementById('campos_adecuacion');

        necesitaAdecuacionCheckbox.addEventListener('change', function () {
            if (this.checked) {
                camposAdecuacion.classList.remove('hidden');
            } else {
                camposAdecuacion.classList.add('hidden');
            }
        });
    });
</script>
@endsection
