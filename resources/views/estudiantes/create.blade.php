@extends('layouts.app')

@section('title', 'Crear Estudiante')

@section('breadcrumbs')
    <div class="text-base text-gray-500 whitespace-nowrap truncate">
        <a href="{{ route('estudiantes.index') }}" class="hover:text-gray-700">Estudiantes</a>
        <span class="mx-2">/</span>
        <span>Crear Nuevo Estudiante</span>
    </div>
@endsection

@section('module_title', 'Crear Nuevo Estudiante')
@section('module_subtitle', 'Ingresa los datos para registrar un nuevo estudiante en el sistema.')

@section('content')
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-3xl mx-auto">
            <form action="#" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cédula -->
                    <div>
                        <x-input-label for="cedula" :value="__('Cédula')" />
                        <x-text-input id="cedula" name="cedula" type="text" class="mt-1 block w-full" required autofocus />
                    </div>

                    <!-- Nacionalidad -->
                    <div>
                        <x-input-label for="nacionalidad" :value="__('Nacionalidad')" />
                        <x-text-input id="nacionalidad" name="nacionalidad" type="text" class="mt-1 block w-full" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Primer Nombre -->
                    <div>
                        <x-input-label for="primer_nombre" :value="__('Primer Nombre')" />
                        <x-text-input id="primer_nombre" name="primer_nombre" type="text" class="mt-1 block w-full" required />
                    </div>

                    <!-- Segundo Nombre -->
                    <div>
                        <x-input-label for="segundo_nombre" :value="__('Segundo Nombre')" />
                        <x-text-input id="segundo_nombre" name="segundo_nombre" type="text" class="mt-1 block w-full" />
                    </div>

                    <!-- Primer Apellido -->
                    <div>
                        <x-input-label for="primer_apellido" :value="__('Primer Apellido')" />
                        <x-text-input id="primer_apellido" name="primer_apellido" type="text" class="mt-1 block w-full" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fecha de Nacimiento -->
                    <div>
                        <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                        <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-.full" required />
                    </div>

                    <!-- Género -->
                    <div>
                        <x-input-label for="genero" :value="__('Género')" />
                        <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Seleccione...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                </div>


                <div class="flex items-center justify-end mt-6">
                    <x-buttons.secondary as="a" href="{{ route('estudiantes.index') }}">
                        Cancelar
                    </x-buttons.secondary>

                    <x-primary-button class="ms-3">
                        Crear Estudiante
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
