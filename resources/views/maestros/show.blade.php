@extends('layouts.app')

@section('title', 'Detalles del Maestro')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('maestros.index') }}" class="hover:text-sigedra-text-dark">Maestros</a>
    <span class="mx-2">/</span>
    <span>Ver información</span>
</div>
@endsection

@section('module_title')
<div class="flex items-center space-x-2">
    <a href="{{ route('maestros.index') }}"
       class="text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out text-2xl"
       title="Volver al listado">
        <i class="ph ph-arrow-left"></i>
    </a>
    <h1 class="text-xl font-semibold">Información de maestro</h1>
</div>
@endsection


@section('header_actions')
<div class="flex items-center justify-between mt-4 gap-3 w-full">
    <div class="flex-shrink-0 flex flex-col md:flex-row md:w-auto gap-3">
        <x-primary-button as="a" href="{{ route('maestros.edit', $maestro->id) }}">
            <i class="ph ph-pencil-simple text-lg"></i>
            <span>Editar Información</span>
        </x-primary-button>
    </div>
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

            </div>

        </div>

    </div>

<x-card-header title="Información de cursos">
    <x-primary-button as="a" href="#" class="hidden md:w-auto md:inline-flex justify-center">
        <i class="ph ph-pencil-simple text-lg"></i>
        <span>Editar Cursos</span>
    </x-primary-button>
</x-card-header>

<div class="space-y-6">
    <div class="bg-sigedra-card border border-sigedra-border rounded-lg p-6">

        Asignaciones cuando esten los modulos correspondientes
    </div>
</div>

@endsection


