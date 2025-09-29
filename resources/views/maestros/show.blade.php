@extends('layouts.app')

@section('title', 'Detalles del Maestro')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('maestros.index') }}" class="hover:text-sigedra-text-dark">Maestros</a>
    <span class="mx-2">/</span>
    <span>Ver información</span>
</div>
@endsection

@section('content')

<h1 class="text-xl font-bold text-gray-800 leading-tight flex items-center justify-between my-4">
    <div class="flex items-center space-x-2">
        <a href="{{ route('maestros.index') }}"
           class="text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out text-2xl"
           title="Volver al listado">
            <i class="ph ph-arrow-left"></i>
        </a>
        <span>Información de maestro</span>
    </div>

    <div class="flex-shrink-0 flex gap-3">
        <x-buttons.primary as="a" href="#">
            <i class="ph ph-pencil-simple text-lg"></i>
            <span>Editar Información</span>
        </x-buttons.primary>
    </div>
</h1>


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

                        <p class="mt-1 text-base text-sigedra-text-medium flex">
                            <span class="w-72"> Cédula: {{ $maestro->user->cedula ?? 'No asignada' }}</span>
                            <span class="mr-2">|</span> Telefono: {{ $maestro->telefono }}
                        </p>

                        <p class="mt-1 text-base text-sigedra-text-medium flex">
                            <span class="w-72"> Nacionalidad: {{$maestro->nacionalidad }}</span>
                            <span class="mr-2">|</span> Correo: {{ $maestro->correo }}
                        </p>

                        <p class="mt-1 text-base text-sigedra-text-medium">
                            Nombramiento desde: {{$maestro->nombramiento_inicio->format('d/m/Y') }}
                        </p>
                        <p class="mt-1 text-base text-sigedra-text-medium">
                            Nombramiento hasta: {{$maestro->nombramiento_final->format('d/m/Y') }}
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
    <x-buttons.primary as="a" href="#">
        <i class="ph ph-pencil-simple text-lg"></i>
        <span>Editar Cursos</span>
    </x-buttons.primary>
</x-card-header>

<div class="space-y-6">
    <div class="bg-sigedra-card border border-sigedra-border rounded-lg p-6">

        Asignaciones cuando esten los modulos correspondientes
    </div>
</div>


@endsection

