@extends('layouts.app')

@section('title', 'Crear Maestro')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('maestros.index') }}" class="hover:text-gray-700">Maestros</a>
    <span class="mx-2">/</span>
    <span>Crear Nuevo Maestro</span>
</div>
@endsection

@section('module_title', 'Crear Nuevo Maestro')
@section('module_subtitle', 'Ingresa los datos para registrar un nuevo maestro en el sistema.')

@section('header_actions')
{{-- Botones de Acción --}}
<div class="flex items-center justify-end mt-4 gap-3">
    <x-buttons.secondary as="a" href="{{ route('maestros.index') }}">
        Cancelar
    </x-buttons.secondary>

    <x-buttons.primary as="button" type="button" onclick="document.getElementById('maestro-form').submit()">
        <i class="ph ph-plus-circle text-lg"></i>
        <span>Guardar Maestro</span>
    </x-buttons.primary>
</div>

@endsection

@section('content')
<div class="w-full">

    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">¡Error del Sistema!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <form action="{{ route('maestros.store') }}" id="maestro-form" method="POST" class="space-y-4">
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

                    <x-input-label for="cedula" value="Cédula" />
                    <x-text-input id="cedula" name="cedula" type="text" maxlength="25" class="mt-1 block w-full @error('cedula') @enderror" value="{{ old('cedula') }}" required placeholder="Identificación del profesor" />

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
                    <x-input-label for="primer_nombre" value="Primer Nombre" />
                    <x-text-input id="primer_nombre" name="primer_nombre" type="text" maxlength="25" class="mt-1 block w-full @error('primer_nombre') @enderror" value="{{ old('primer_nombre') }}" required placeholder="Juan" />

                    @error('primer_nombre')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Segundo Nombre --}}
                <div>
                    <x-input-label for="segundo_nombre" value="Segundo Nombre (Opcional)" />
                    <x-text-input id="segundo_nombre" name="segundo_nombre" type="text" maxlength="25" placeholder="Carlos" class="mt-1 block w-full @error('segundo_nombre') @enderror" value="{{ old('segundo_nombre') }}" />

                    @error('segundo_nombre')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Primer Apellido --}}
                <div>
                    <x-input-label for="primer_apellido" value="Primer Apellido" />
                    <x-text-input id="primer_apellido" name="primer_apellido" type="text" maxlength="25" class="mt-1 block w-full @error('primer_nombre') @enderror" value="{{ old('primer_nombre') }}" required placeholder="Pérez" />

                    @error('primer_apellido')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Segundo Apellido --}}
                <div>
                    <x-input-label for="segundo_apellido" value="Segundo Apellido (Opcional)" />
                    <x-text-input id="segundo_apellido" name="segundo_apellido" type="text" maxlength="25" class="mt-1 block w-full @error('segundo_apellido') @enderror"  value="{{ old('segundo_apellido') }}" placeholder="Rojas" />

                    @error('segundo_apellido')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Telefono, Correo y Nacionalidad --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start mt-6">

                {{-- Telefono --}}
                <div>
                    <x-input-label for="telefono" value="Telefono" />
                    <x-text-input id="telefono" name="telefono" type="text" maxlength="8" class="mt-1 block w-full @error('telefono') @enderror"  value="{{ old('telefono') }}" placeholder="Ej: 88889999" />

                    @error('telefono')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correo --}}
                <div>
                    <x-input-label for="correo" value="Correo" />
                    <x-text-input id="correo" name="correo" type="text" maxlength="100" class="mt-1 block w-full @error('correo') @enderror"  value="{{ old('correo') }}" placeholder="Ej: ejemplo@gmail.com" />

                    @error('correo')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nacionalidad --}}
                <div>
                    <x-input-label for="nacionalidad" value="Nacionalidad" />
                    <x-text-input id="nacionalidad" name="nacionalidad" type="text" maxlength="25" class="mt-1 block w-full @error('nacionalidad') @enderror"  value="{{ old('nacionalidad') }}" placeholder="Ej: Costarricense" />

                    @error('nacionalidad')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Apartado de Nombramiento --}}
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Nombramiento asignado al maestro</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Fecha de nombramiento Inicio--}}
                    <div>
                        <x-input-label for="nombramiento_inicio" value="Desde" />
                        <x-text-input id="nombramiento_inicio" name="nombramiento_inicio" type="date" class="mt-1 block w-full @error('nombramineto_inicio') @enderror"  value="{{ old('nombramiento_inicio') }}" required />

                        @error('nombramiento_inicio')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha de nombramiento Final--}}
                    <div>
                        <x-input-label for="nombramiento_final" value="Hasta" />
                        <x-text-input id="nombramiento_final" name="nombramiento_final" type="date" class="mt-1 block w-full @error('nombraamiento_final') @enderror"  value="{{ old('nombramiento_final') }}" required />

                        @error('nombramiento_final')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        </div>
    </form>
</div>

@endsection
