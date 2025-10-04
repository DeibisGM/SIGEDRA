@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('estudiantes.index') }}" class="hover:text-gray-700">Estudiantes</a>
    <span class="mx-2">/</span>
    <span class="font-semibold text-indigo-600">{{ $student->nombre_completo }}</span>
</div>
@endsection

@section('module_title')
<div class="flex items-center space-x-2">
    <a href="{{ route('estudiantes.index') }}"
       class="text-gray-500 hover:text-gray-900 transition duration-150 ease-in-out text-2xl"
       title="Volver al listado">
        <i class="ph ph-arrow-left"></i>
    </a>
    <h1 class="text-xl font-semibold">Información de estudiantes</h1>
</div>
@endsection
@section('content')
<div class="space-y-6">
    <!-- Card de Perfil del Estudiante -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <div class="flex flex-col md:flex-row items-start gap-6">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-sigedra-primary text-white">
                    <span class="text-3xl font-bold">{{ $student->avatar_initials }}</span>
                </span>
            </div>

            <!-- Información Principal -->
            <div class="flex-grow">
                <h1 class="text-3xl font-bold text-sigedra-primary">{{ $student->nombre_completo }}</h1>
                <p class="mt-1 text-base text-gray-600">
                    Cédula: {{ $student->cedula }}
                    @if($grado_actual)
                        <span class="mx-2">|</span>
                        Grado Actual: <strong>{{ $grado_actual->nivelAcademico->nombre }}</strong>
                    @endif
                </p>
                <div class="mt-3 flex items-center gap-x-3">
                    @if($student->activo)
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Activo
                        </span>
                    @else
                        <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Inactivo
                        </span>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            <div class="w-full md:w-auto flex-shrink-0 flex gap-3">
                <x-secondary-button as="a" href="#">
                    <i class="ph ph-printer text-lg"></i>
                    <span>Imprimir</span>
                </x-secondary-button>
                <x-secondary-button href="{{ route('estudiantes.edit', $student) }}" title="Editar Estudiante">
                    <i class="ph ph-pencil-simple text-lg"></i>
                </x-secondary-button>
            </div>
        </div>
    </div>

    <!-- Información Adicional -->
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Información Personal</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $student->fecha_nacimiento->format('d/m/Y') }} ({{ $student->edad }} años)</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Género</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @if($student->genero == 'M') Masculino
                    @elseif($student->genero == 'F') Femenino
                    @else Otro
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Nacionalidad</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $student->nacionalidad ?? 'No especificada' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $student->direccion ?? 'No especificada' }}</dd>
            </div>
        </dl>
    </div>
</div>
@endsection
