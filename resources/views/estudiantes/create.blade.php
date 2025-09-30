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

@section('header_actions')
{{-- Botones de Acción --}}
<div class="flex items-center justify-end mt-4 gap-3">
    <x-secondary-button as="a" href="{{ route('estudiantes.index') }}">
        Cancelar
    </x-secondary-button>

    <x-primary-button>
        <i class="ph ph-plus-circle text-lg"></i>
        <span>Guardar Estudiante</span>
    </x-primary-button>
</div>
@endsection

@section('content')
<div class="w-full">
    <form action="#" method="POST" class="space-y-4">
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

                {{-- Cédula con botón de búsqueda --}}
                <div class="md:col-span-2">
                    <x-input-label for="cedula" value="Cédula" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <x-text-input id="cedula" name="cedula" type="text" class="flex-1 block w-full rounded-none rounded-l-md" required autofocus placeholder="Buscar estudiante por cédula..." />
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-700 hover:bg-gray-100 rounded-r-md">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                            <span class="ml-2 hidden sm:block">Buscar</span>
                        </button>
                    </div>
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
                    <x-input-label for="primer_nombre" value="Primer Nombre" />
                    <x-text-input id="primer_nombre" name="primer_nombre" type="text" class="mt-1 block w-full" required placeholder="Juan" />
                </div>

                {{-- Segundo Nombre --}}
                <div>
                    <x-input-label for="segundo_nombre" value="Segundo Nombre (Opcional)" />
                    <x-text-input id="segundo_nombre" name="segundo_nombre" type="text" class="mt-1 block w-full" placeholder="Carlos" />
                </div>

                {{-- Primer Apellido --}}
                <div>
                    <x-input-label for="primer_apellido" value="Primer Apellido" />
                    <x-text-input id="primer_apellido" name="primer_apellido" type="text" class="mt-1 block w-full" required placeholder="Pérez" />
                </div>

                {{-- Segundo Apellido --}}
                <div>
                    <x-input-label for="segundo_apellido" value="Segundo Apellido (Opcional)" />
                    <x-text-input id="segundo_apellido" name="segundo_apellido" type="text" class="mt-1 block w-full" placeholder="Rojas" />
                </div>
            </div>

            {{-- Fecha de Nacimiento, Género y Nacionalidad --}}
            {{-- CAMBIO: Se ajusta el grid a 3 columnas en 'lg' y se elimina el col-span --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end mt-6">
                {{-- Fecha de Nacimiento --}}
                <div>
                    <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
                    <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" required />
                </div>

                {{-- Género --}}
                <div>
                    <x-input-label for="genero" value="Género" />
                    <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="" disabled selected>Seleccione...</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                        <option value="O">Otro</option>
                    </select>
                </div>

                {{-- Nacionalidad --}}
                <div>
                    <x-input-label for="nacionalidad" value="Nacionalidad" />
                    <x-text-input id="nacionalidad" name="nacionalidad" type="text" class="mt-1 block w-full" placeholder="Ej: Costarricense" />
                </div>
            </div>

            {{-- Apartado de Dirección --}}
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Dirección</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Provincia --}}
                    <div>
                        <x-input-label for="provincia" value="Provincia (Opcional)" />
                        <x-text-input id="provincia" name="provincia" type="text" class="mt-1 block w-full" placeholder="Ej: San José" />
                    </div>
                    {{-- Cantón --}}
                    <div>
                        <x-input-label for="canton" value="Cantón (Opcional)" />
                        <x-text-input id="canton" name="canton" type="text" class="mt-1 block w-full" placeholder="Ej: Desamparados" />
                    </div>
                    {{-- Distrito --}}
                    <div>
                        <x-input-label for="distrito" value="Distrito (Opcional)" />
                        <x-text-input id="distrito" name="distrito" type="text" class="mt-1 block w-full" placeholder="Ej: San Miguel" />
                    </div>
                    {{-- Dirección Exacta --}}
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-input-label for="direccion_exacta" value="Dirección Exacta (Opcional)" />
                        <textarea id="direccion_exacta" name="direccion_exacta" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Ej: 100 metros al sur del parque central, casa color verde con portón negro."></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Card: Información Académica --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Información Académica</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="grado_id" value="Grado a Matricular" />
                    <select id="grado_id" name="grado_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="" disabled selected>Seleccione un grado...</option>
                        <option value="1">Primer Grado</option>
                        <option value="2">Segundo Grado</option>
                        <option value="3">Tercer Grado</option>
                        <option value="4">Cuarto Grado</option>
                        <option value="5">Quinto Grado</option>
                        <option value="6">Sexto Grado</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- 4. Card: Necesidades Especiales (Adecuación) --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Necesidades Especiales (Adecuación)</h2>
            <div class="space-y-6">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="necesita_adecuacion" name="necesita_adecuacion" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="necesita_adecuacion" class="font-medium text-gray-800">El estudiante requiere adecuación curricular</label>
                        <p class="text-gray-500">Marque esta casilla si el estudiante necesita algún tipo de apoyo o adecuación.</p>
                    </div>
                </div>

                <div id="campos_adecuacion" class="hidden pl-8 mt-4 space-y-6 border-l-2 border-indigo-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="adecuacion_id" value="Tipo de Adecuación" />
                            <select id="adecuacion_id" name="adecuacion_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>Seleccione un tipo...</option>
                                <option value="1">No Significativa</option>
                                <option value="2">Significativa</option>
                                <option value="3">De Acceso</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <x-input-label for="adecuacion_detalles" value="Detalles y Observaciones" />
                        <textarea id="adecuacion_detalles" name="adecuacion_detalles" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Describa las recomendaciones..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Card: Asignación de Encargado --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Asignación de Encargado</h2>

            <div class="p-4 mb-6 border-l-4 border-blue-400 bg-blue-50">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-800">Busque un encargado existente por cédula. Si no lo encuentra, podrá registrarlo como uno nuevo.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="encargado_cedula" value="Buscar Encargado por Cédula" />
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <x-text-input id="encargado_cedula" name="encargado_cedula" type="text" class="flex-1 block w-full rounded-none rounded-l-md" placeholder="Cédula del encargado"/>
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-700 hover:bg-gray-100 rounded-r-md">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                            <span class="ml-2 hidden sm:block">Buscar</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <span class="text-sm font-medium text-gray-900">Encargados Asignados:</span>
                <div class="mt-2 p-4 bg-gray-50 rounded-md border min-h-[60px]">
                    <p class="text-sm text-gray-500">Ningún encargado asignado todavía.</p>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const necesitaAdecuacionCheckbox = document.getElementById('necesita_adecuacion');
        const camposAdecuacion = document.getElementById('campos_adecuacion');

        const toggleAdecuacionFields = () => {
            if (necesitaAdecuacionCheckbox.checked) {
                camposAdecuacion.classList.remove('hidden');
            } else {
                camposAdecuacion.classList.add('hidden');
            }
        };

        necesitaAdecuacionCheckbox.addEventListener('change', toggleAdecuacionFields);
        toggleAdecuacionFields(); // Ejecutar al cargar la página
    });
</script>
@endpush

@endsection
