@extends('layouts.app')

@section('title', 'Detalles del Estudiante')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('estudiantes.index') }}" class="hover:text-gray-700">Estudiantes</a>
    <span class="mx-2">/</span>
    <span class="font-semibold text-sigedra-primary">{{ $student->nombre_completo }}</span>
</div>
@endsection

{{-- No se usa module_title ni subtitle para dar espacio al nuevo layout de perfil --}}
@section('module_title', '')
@section('module_subtitle', '')

@section('content')
<div class="space-y-6">
    <!-- Card de Perfil del Estudiante -->
    <div class="bg-white border border-sigedra-border rounded-lg p-6">
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
                {{-- CAMBIO: Se elimina la "Sección" de esta línea --}}
                <p class="mt-1 text-base text-sigedra-text-medium">
                    Cédula: {{ $student->cedula }} <span class="mx-2">|</span> Grado Actual: <strong>{{ $student->grado_actual }}</strong>
                </p>
                <div class="mt-3 flex items-center gap-x-3">
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $student->status }}</span>
                    @if($student->adecuacion && $student->adecuacion->requiere)
                    <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ $student->adecuacion->tipo }}</span>
                    @endif
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

    <!-- Pestañas de Navegación -->
    {{-- CAMBIO: La pestaña por defecto ahora es 'general' --}}
    <div x-data="{ tab: 'general' }">
        <div class="border-b border-sigedra-border">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                <button @click="tab = 'general'"
                        :class="tab === 'general' ? 'border-sigedra-primary text-sigedra-primary' : 'border-transparent text-sigedra-text-medium hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Información General
                </button>
                <button @click="tab = 'academico'"
                        :class="tab === 'academico' ? 'border-sigedra-primary text-sigedra-primary' : 'border-transparent text-sigedra-text-medium hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Historial Académico
                </button>
                <button @click="tab = 'asistencia'"
                        :class="tab === 'asistencia' ? 'border-sigedra-primary text-sigedra-primary' : 'border-transparent text-sigedra-text-medium hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Asistencia
                </button>
                <button @click="tab = 'bitacora'"
                        :class="tab === 'bitacora' ? 'border-sigedra-primary text-sigedra-primary' : 'border-transparent text-sigedra-text-medium hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Bitácora
                </button>
            </nav>
        </div>

        <div class="py-6">
            <!-- Pestaña: Historial Académico -->
            <div x-show="tab === 'academico'" class="space-y-6">
                <x-student-course-details :courses="$current_courses" :history="$academic_history" />
            </div>

            <!-- Pestaña: Información General -->
            {{-- CAMBIO: Se elimina la clase de espaciado (space-y-6) de este div --}}
            <div x-show="tab === 'general'">
                <x-student-personal-details :student="$student" />
            </div>

            <!-- Pestaña: Asistencia -->
            <div x-show="tab === 'asistencia'">
                <p class="text-gray-600">Aquí se mostrará un resumen y un historial detallado de la asistencia del estudiante.</p>
            </div>

            <!-- Pestaña: Bitácora -->
            <div x-show="tab === 'bitacora'">
                <p class="text-gray-600">Aquí se mostrarán las observaciones y anotaciones de los profesores sobre el estudiante.</p>
            </div>
        </div>
    </div>
</div>
@endsection
