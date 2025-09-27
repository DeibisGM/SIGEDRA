@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('estudiantes.index') }}" class="hover:text-sigedra-text-dark">Estudiantes</a>
    <span class="mx-2">/</span>
    <span class="font-semibold text-sigedra-primary">{{ $student->nombre_completo }}</span>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Card de Perfil del Estudiante -->
    <div class="bg-sigedra-card border border-sigedra-border rounded-lg p-6">
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
                <p class="mt-1 text-base text-sigedra-text-medium">
                    Cédula: {{ $student->cedula }}
                    @if($student->grados->isNotEmpty())
                    <span class="mx-2">|</span> Grado Actual: <strong>{{ $student->grados->last()->nivelAcademico->nombre }}</strong>
                    @endif
                </p>
                <div class="mt-3 flex items-center gap-x-3">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                    {{-- Lógica para adecuación podría ir aquí --}}
                </div>
            </div>

            <!-- Acciones -->
            <div class="w-full md:w-auto flex-shrink-0 flex gap-3">
                <x-buttons.secondary as="a" href="#">
                    <i class="ph ph-printer text-lg"></i>
                    <span>Imprimir</span>
                </x-buttons.secondary>
                <x-buttons.primary as="a" href="#">
                    <i class="ph ph-pencil-simple text-lg"></i>
                    <span>Editar</span>
                </x-buttons.primary>
            </div>
        </div>
    </div>
</div>
@endsection
