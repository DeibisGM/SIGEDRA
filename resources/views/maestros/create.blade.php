@extends('layouts.app')

@php
$isEdit = isset($maestro);
$user = auth()->user();
$isOwnProfile = $isEdit && $user && $user->maestro && $user->maestro->id === $maestro->id;

// Títulos y textos dinámicos
$title = $isEdit ? ($isOwnProfile ? 'Editar Mi Perfil' : 'Editar Maestro') : 'Crear Maestro';
$subtitle = $isEdit ? 'Modifica los datos del maestro y su usuario asociado.' : 'Ingresa los datos para registrar un nuevo maestro en el sistema.';
$buttonText = $isEdit ? 'Guardar Cambios' : 'Guardar Maestro';
$buttonIcon = $isEdit ? 'ph ph-floppy-disk' : 'ph ph-plus-circle';
@endphp

@section('title', $title)

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    @if ($isOwnProfile)
        <a href="{{ route('maestros.show', $maestro->id) }}" class="hover:text-gray-700">Mi Perfil</a>
        <span class="mx-2">/</span>
        <span>Editar Perfil</span>
    @else
        <a href="{{ route('maestros.index') }}" class="hover:text-gray-700">Maestros</a>
        <span class="mx-2">/</span>
        <span>{{ $isEdit ? 'Editar Maestro' : 'Crear Nuevo Maestro' }}</span>
    @endif
</div>
@endsection

@section('module_title', $title)
@section('module_subtitle', $subtitle)

@section('header_actions')
<div class="hidden md:flex items-center justify-end mt-4 gap-3">
    @if ($isOwnProfile)
    <x-secondary-button as="a" href="{{ route('maestros.show', $maestro->id) }}">
        Cancelar
    </x-secondary-button>
    @else
    <x-secondary-button as="a" href="{{ route('maestros.index') }}">
        Cancelar
    </x-secondary-button>
    @endif

    @if ($isEdit)
    <x-primary-button as="button" type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'pre-update-modal')">
        <i class="{{ $buttonIcon }} text-lg"></i>
        <span>{{ $buttonText }}</span>
    </x-primary-button>
    @endif

    @if (!$isEdit)
    <x-primary-button as="button" type="button" onclick="document.getElementById('maestro-form').submit()">
        <i class="{{ $buttonIcon }} text-lg"></i>
        <span>{{ $buttonText }}</span>
    </x-primary-button>
    @endif

</div>
@endsection

@section('content')
<div class="w-full">

    @if (session('success'))
    <x-flash-message type="success" :message="session('success')" />
    @endif

    @if (session('error'))
    <x-flash-message type="error" :message="session('error')" />
    @endif

    <form action="{{ $isEdit ? route('maestros.update', $maestro) : route('maestros.store') }}" id="maestro-form" method="POST" class="space-y-4">
        @csrf

        @if ($isEdit)
        @method('PUT')
        @endif

        {{-- 1. Card: Información de Identidad --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Información de Identidad</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Tipo de Identificación --}}
                <div>
                    <x-input-label for="tipo_identificacion" value="Tipo de Identificación" />
                    <select id="tipo_identificacion" name="tipo_identificacion" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                        <option value="nacional" @selected(old('tipo_identificacion', $maestro->tipo_identificacion ?? 'nacional') == 'nacional')>Nacional</option>
                        <option value="extranjero" @selected(old('tipo_identificacion', $maestro->tipo_identificacion ?? 'nacional') == 'extranjero')>Extranjero</option>
                    </select>
                </div>

                {{-- Cédula --}}
                <div class="md:col-span-2">
                    @if ($isEdit)
                        <x-input-label for="cedula" value="Cédula" />
                        <x-text-input id="cedula" type="text" class="mt-1 block w-full @error('cedula') @enderror" value="{{ old('cedula', optional($maestro->user)->cedula) }}" disabled />
                        <input type="hidden" name="cedula" value="{{ old('cedula', optional($maestro->user)->cedula) }}">
                    @endif

                    @if (!$isEdit)
                        <x-input-label for="cedula" value="Cédula*" />
                        <x-text-input id="cedula" name="cedula" type="text" maxlength="25" class="mt-1 block w-full @error('cedula') @enderror" value="{{ old('cedula') }}" required placeholder="Identificación del profesor" />
                    @endif

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
                    <x-text-input id="primer_nombre" name="primer_nombre" type="text" maxlength="25" class="mt-1 block w-full @error('primer_nombre') @enderror"
                                  value="{{ old('primer_nombre', $maestro->primer_nombre ?? '') }}"
                                  required placeholder="Juan" />

                    @error('primer_nombre')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Segundo Nombre --}}
                <div>
                    <x-input-label for="segundo_nombre" value="Segundo Nombre" />
                    <x-text-input id="segundo_nombre" name="segundo_nombre" type="text" maxlength="25" placeholder="Carlos" class="mt-1 block w-full @error('segundo_nombre') @enderror"
                                  value="{{ old('segundo_nombre', $maestro->segundo_nombre ?? '') }}" />

                    @error('segundo_nombre')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Primer Apellido --}}
                <div>
                    <x-input-label for="primer_apellido" value="Primer Apellido*" />
                    <x-text-input id="primer_apellido" name="primer_apellido" type="text" maxlength="25" class="mt-1 block w-full @error('primer_apellido') @enderror"
                                  value="{{ old('primer_apellido', $maestro->primer_apellido ?? '') }}"
                                  required placeholder="Pérez" />

                    @error('primer_apellido')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Segundo Apellido --}}
                <div>
                    <x-input-label for="segundo_apellido" value="Segundo Apellido" />
                    <x-text-input id="segundo_apellido" name="segundo_apellido" type="text" maxlength="25" class="mt-1 block w-full @error('segundo_apellido') @enderror"
                                  value="{{ old('segundo_apellido', $maestro->segundo_apellido ?? '') }}"
                                  placeholder="Rojas" />

                    @error('segundo_apellido')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Telefono, Correo y Nacionalidad --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start mt-6">

                {{-- Telefono --}}
                <div>
                    <x-input-label for="telefono" value="Telefono*" />
                    <x-text-input id="telefono" name="telefono" type="text" maxlength="8" class="mt-1 block w-full @error('telefono') @enderror"
                                  value="{{ old('telefono', $maestro->telefono ?? '') }}"
                                  placeholder="Ej: 88889999" />

                    @error('telefono')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correo --}}
                <div>
                    <x-input-label for="correo" value="Correo*" />
                    <x-text-input id="correo" name="correo" type="text" maxlength="100" class="mt-1 block w-full @error('correo') @enderror"
                                  value="{{ old('correo', $maestro->user->email ?? '') }}"
                                  placeholder="Ej: ejemplo@gmail.com" />

                    @error('correo')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nacionalidad --}}
                <div>
                    <x-input-label for="nacionalidad" value="Nacionalidad*" />
                    <x-text-input id="nacionalidad" name="nacionalidad" type="text" maxlength="25" class="mt-1 block w-full @error('nacionalidad') @enderror"
                                  value="{{ old('nacionalidad', $maestro->nacionalidad ?? '') }}"
                                  placeholder="Ej: Costarricense" />

                    @error('nacionalidad')
                    <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 3. Card: Nombramientos --}}
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            {{-- Nombramiento --}}
            <div >
                <h3 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Nombramiento asignado al maestro</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    {{-- Fecha de nombramiento Inicio--}}
                    <div>
                        <x-input-label for="nombramiento_inicio" value="Desde*" />

                        <div class="relative max-w-sm mt-1">
                            <div class="absolute inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                <i class="ph ph-calendar-blank w-4 h-4 text-sigedra-text-medium"></i>
                            </div>
                            <input id="nombramiento_inicio" type="text" name="nombramiento_inicio" class="custom-datepicker h-11 bg-white border border-sigedra-border text-sigedra-text-dark text-sm rounded-lg focus:border-sigedra-text-medium block w-full pe-10 p-2.5"
                                   placeholder="Seleccionar fecha" autocomplete="off" wire:model.defer="nombramiento_inicio" value="{{ old('nombramiento_inicio', $isEdit ? $maestro->nombramiento_inicio?->format('Y-m-d') : '') }}"
                                   required>
                        </div>

                        @error('nombramiento_inicio')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fecha de nombramiento Final--}}
                    <div>
                        <x-input-label for="nombramiento_final" value="Hasta*" />
                        <div class="relative max-w-sm mt-1">
                            <div class="absolute inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                                <i class="ph ph-calendar-blank w-4 h-4 text-sigedra-text-medium"></i>
                            </div>
                            <input id="nombramiento_final" type="text" name="nombramiento_final" class="custom-datepicker h-11 bg-white border border-sigedra-border text-sigedra-text-dark text-sm rounded-lg focus:border-sigedra-text-medium block w-full pe-10 p-2.5"
                                   placeholder="Seleccionar fecha" autocomplete="off" wire:model.defer="nombramiento_final" value="{{ old('nombramiento_final', $isEdit ? $maestro->nombramiento_final?->format('Y-m-d') : '') }}"
                                   required>
                        </div>

                        @error('nombramiento_final')
                        <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- 4. Card: Datos criticos --}}
        @if ($isEdit)
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            {{-- Datos criticos --}}
            <div >
                <h3 class="text-xl font-semibold border-b border-gray-200 pb-4 mb-6">Datos de acceso al sistema</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">

                    {{-- Contrasena --}}
                    <div x-data="{ showPasswordFields: @json($errors->has('password') || $errors->has('password_confirmation')) }" class="pt-1">
                        <x-input-label value="Actualizar contraseña" />

                        <div class="mb-4">
                            <button type="button"
                                    @click="showPasswordFields = !showPasswordFields"
                                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                <span x-text="showPasswordFields ? 'Cancelar Cambio' : 'CAMBIAR CONTRASEÑA'"></span>
                            </button>

                            <p class="text-sm text-gray-500 mt-2" x-show="!showPasswordFields">
                                La contraseña solo se puede modificar usando el botón de arriba.
                            </p>
                        </div>

                        {{-- Los campos de Contraseña (Solo se muestran si showPasswordFields es true) --}}
                        <div x-show="showPasswordFields"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            {{-- Nueva Contraseña --}}
                            <div>
                                <x-input-label for="password" value="Contraseña Nueva" />
                                <x-text-input id="password" name="password" type="password" maxlength="100"
                                              class="mt-1 block w-full @error('password') @enderror"
                                              placeholder="Mínimo 8 caracteres"
                                              x-bind:required="showPasswordFields" />

                                @error('password')
                                <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirmar Contraseña --}}
                            <div>
                                <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" maxlength="100"
                                              class="mt-1 block w-full"
                                              placeholder="Repetir la contraseña"
                                              x-bind:required="showPasswordFields" />

                                @error('password_confirmation')
                                <p class="text-sm text-sigedra-error mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Campo de Activo --}}
                    <div class="md:col-span-2 lg:col-span-1">
                        <x-input-label for="activo" value="Estado*" />

                        <select id="activo" name="activo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="1" @selected(old('activo', $maestro->activo) == 1)>Activo</option>
                            <option value="0" @selected(old('activo', $maestro->activo) == 0)>Inactivo</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
        @endif
</div>
</form>
</div>
@endsection

@section('footer_actions')
{{-- Botones de Acción para Móvil --}}
<div class="fixed inset-x-0 bottom-0 z-40 p-4 bg-white border-t border-gray-200 md:hidden shadow-lg">
    <div class="flex items-center gap-3">
        <x-secondary-button as="a" href="{{ route('maestros.index') }}">
            Cancelar
        </x-secondary-button>

        @if ($isEdit)
        <x-primary-button as="button" type="button" x-data x-on:click.prevent="$dispatch('open-modal', 'pre-update-modal')" class="flex-grow justify-center">
            <i class="{{ $buttonIcon }} text-lg"></i>
            <span> Guardar </span>
        </x-primary-button>
        @endif

        @if (!$isEdit)
        <x-primary-button as="button" type="button" onclick="document.getElementById('maestro-form').submit()" class="flex-grow justify-center">
            <i class="{{ $buttonIcon }} text-lg"></i>
            <span> Guardar </span>
        </x-primary-button>
        @endif
    </div>
</div>
@endsection

@if ($isEdit)
<x-pre-update-modal
    name="pre-update-modal"
    form-id="maestro-form"
    title="Confirmar Actualización de Maestro"
    text="Estás a punto de guardar los cambios. ¿Deseas continuar?"
/>
@endif
