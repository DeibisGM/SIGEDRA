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
    <x-card>
        <form action="{{ route('estudiantes.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cédula -->
                <div>
                    <x-input-label for="cedula" :value="__('Cédula')" />
                    <x-text-input id="cedula" name="cedula" type="text" class="mt-1 block w-full" :value="old('cedula')" required autofocus />
                    <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                </div>

                <!-- Nacionalidad -->
                <div>
                    <x-input-label for="nacionalidad" :value="__('Nacionalidad')" />
                    <x-text-input id="nacionalidad" name="nacionalidad" type="text" class="mt-1 block w-full" :value="old('nacionalidad')" />
                    <x-input-error :messages="$errors->get('nacionalidad')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Primer Nombre -->
                <div>
                    <x-input-label for="primer_nombre" :value="__('Primer Nombre')" />
                    <x-text-input id="primer_nombre" name="primer_nombre" type="text" class="mt-1 block w-full" :value="old('primer_nombre')" required />
                    <x-input-error :messages="$errors->get('primer_nombre')" class="mt-2" />
                </div>

                <!-- Segundo Nombre -->
                <div>
                    <x-input-label for="segundo_nombre" :value="__('Segundo Nombre')" />
                    <x-text-input id="segundo_nombre" name="segundo_nombre" type="text" class="mt-1 block w-full" :value="old('segundo_nombre')" />
                    <x-input-error :messages="$errors->get('segundo_nombre')" class="mt-2" />
                </div>

                <!-- Primer Apellido -->
                <div>
                    <x-input-label for="primer_apellido" :value="__('Primer Apellido')" />
                    <x-text-input id="primer_apellido" name="primer_apellido" type="text" class="mt-1 block w-full" :value="old('primer_apellido')" required />
                    <x-input-error :messages="$errors->get('primer_apellido')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Fecha de Nacimiento -->
                <div>
                    <x-input-label for="fecha_nacimiento" :value="__('Fecha de Nacimiento')" />
                    <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento')" required />
                    <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>

                <!-- Género -->
                <div>
                    <x-input-label for="genero" :value="__('Género')" />
                    <select id="genero" name="genero" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione...</option>
                        <option value="M" {{ old('genero') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') == 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                    <x-input-error :messages="$errors->get('genero')" class="mt-2" />
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
    </x-card>
@endsection
