@extends('layouts.app')

@php
$user = auth()->user();
$isOwnProfile = $user && $user->maestro && $user->maestro->id === $maestro->id;
@endphp

@section('title', 'Detalles del Maestro')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    @if ($isOwnProfile)
        <span>Mi Perfil</span>
    @else
        <a href="{{ route('maestros.index') }}" class="hover:text-sigedra-text-dark">Maestros</a>
        <span class="mx-2">/</span>
        <span>Ver información</span>
    @endif
</div>
@endsection

@section('module_title')
<div class="flex items-center space-x-2">
    @if (!$isOwnProfile)
    <a href="{{ route('maestros.index') }}"
       class="text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out text-2xl"
       title="Volver al listado">
        <i class="ph ph-arrow-left"></i>
    </a>
    @endif
    <h1 class="text-xl font-semibold">
        @if ($isOwnProfile)
            Información de Perfil
        @else
            Información de maestro
        @endif
    </h1>
</div>
@endsection


@section('header_actions')
<div class="flex-shrink-0 flex flex-col md:flex-row md:w-auto gap-3 hidden lg:block">
    <x-primary-button as="a" href="{{ route('maestros.edit', $maestro->id) }}">
        <i class="ph ph-pencil-simple text-lg"></i>
        <span>Editar Información</span>
    </x-primary-button>
</div>
@endsection


@section('content')
@if (session('success'))
<x-flash-message type="success" :message="session('success')" />
@endif

@if (session('error'))
<x-flash-message type="error" :message="session('error')" />
@endif

    <div class="space-y-6">
        <div class="bg-sigedra-card border border-sigedra-border rounded-lg p-6">
            <div class="flex flex-col md:flex-row items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-sigedra-primary text-white">
                    <span class="text-3xl font-bold">{{ $maestro->avatar_initials }}</span>
                </span>
                </div>

                <!-- Información Principal -->
                <div class="flex-grow">
                    <h1 class="text-3xl font-bold text-sigedra-primary">{{ $maestro->nombre_completo }}</h1>
                    <div class="flex-grow">

                        <div class="grid grid-cols-1 sm:grid-cols-[auto_1fr_auto_1fr] gap-y-1 sm:gap-x-12 mt-1 text-base text-sigedra-text-medium">

                            <div class="sm:col-span-2">Cédula: {{ $maestro->user->cedula ?? 'No asignada' }}</div>

                            <div class="sm:col-span-2">Telefono: {{ $maestro->telefono ?? 'N/A'}}</div>

                            <div class="sm:col-span-2">Nacionalidad: {{$maestro->nacionalidad }}</div>

                            <div class="sm:col-span-2">Correo: {{ $maestro->user->email ?? 'N/A' }}</div>
                        </div>

                        <p class="mt-1 text-base text-sigedra-text-medium">
                            Nombramiento desde: {{ $maestro->nombramiento_inicio?->format('d/m/Y') ?? 'N/A' }}
                        </p>
                        <p class="mt-1 text-base text-sigedra-text-medium">
                            Nombramiento hasta: {{ $maestro->nombramiento_final?->format('d/m/Y') ?? 'N/A' }}
                        </p>
                    </div>


                </div>


                    <div class="mt-3 flex items-center gap-x-3">
                        @if($maestro->activo)
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                        @else
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>
                        @endif
                    </div>

                    <div class="md:hidden w-full">
                        <x-primary-button class="md:hidden w-full" as="a" href="{{ route('maestros.edit', $maestro->id) }}">
                            <i class="ph ph-pencil-simple text-lg"></i>
                            <span>Editar Información</span>
                        </x-primary-button>
                    </div>


            </div>

        </div>

    </div>

<div class="p-4">
    <h3 class="text-xl font-semibold">Información de cursos</h3>
    <p class="text-sm text-gray-600 mt-1">Competencia academica</p>
</div>



@if ($maestro->materias->isEmpty())
<div class="text-center py-10 w-full">
    <p class="text-gray-500">No hay materias registradas para este maestro.</p>
</div>
@else
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach ($maestro->materias as $materia)
    <div x-data="{ openMenu: false }" class="bg-white border rounded-lg p-4">

        <div class="flex justify-between items-start">
            <div>
                <p class="font-bold text-lg">{{ $materia->nombre ?? 'N/A' }}</p>
                <p class="text-sm text-gray-600"><span>Descripción: </span>{{ $materia->descripcion ?? 'N/A' }}</p>
            </div>

            {{-- menu de acciones --}}
            <div class="relative">

                {{-- Botón para abrir/cerrar --}}
                <button type="button" @click="openMenu = !openMenu" title="Opciones" class="p-1 -mt-1 -mr-1">
                    <i class="ph ph-dots-three-vertical text-xl text-gray-600 hover:text-gray-900"></i>
                </button>

                <div x-show="openMenu"
                     @click.outside="openMenu = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95"

                     class="absolute z-10 top-full right-0 mt-0 p-2 bg-white border border-gray-200 rounded-md shadow-lg
                            flex flex-col space-y-1">

                    {{-- Botones de acción aquí... --}}
                    <x-secondary-button as="a" href="#" title="Ver información">
                        <i class="ph ph-eye text-lg"></i>
                        <span>Ver</span>
                    </x-secondary-button>
                    <x-secondary-button as="a" href="#" title="Editar Materia">
                        <i class="ph ph-pencil-simple text-lg"></i>
                        <span>Editar </span>
                    </x-secondary-button>
                    <x-danger-button title="Eliminar Materia">
                        <i class="ph ph-trash text-lg"></i>
                        <span>Eliminar</span>
                    </x-danger-button>
                </div>
            </div>
        </div>

        <div class="mt-3 flex items-center gap-x-3">
            @if($materia->tipo)
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">Especial</span>
            @else
            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-violet-100 text-violet-800">General</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection


