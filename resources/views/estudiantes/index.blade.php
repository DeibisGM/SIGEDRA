@extends('layouts.app')

@section('title', 'Estudiantes')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('estudiantes.index') }}" class="hover:text-gray-700">Estudiantes</a>
    <span class="mx-2">/</span>
    <span>Gestión de Estudiantes</span>
</div>
@endsection

@section('module_title', 'Gestión de Estudiantes')
@section('module_subtitle', 'Administra los estudiantes de tus cursos.')

@section('header_actions')
{{-- Los filtros ahora se manejan dentro del componente Livewire para reactividad --}}
<div class="hidden md:flex items-center gap-3">
    <div class="flex-grow"></div>

    {{-- Botón para crear un nuevo estudiante --}}
    <x-primary-button as="a" href="{{ route('estudiantes.create') }}">
        <i class="ph ph-plus-circle text-lg"></i>
        <span class="ms-2">Crear Estudiante</span>
    </x-primary-button>
</div>
@endsection

@section('content')
{{-- Aquí es donde se carga toda la funcionalidad. Livewire se encarga del resto. --}}
@livewire('gestion-estudiantes')
@endsection
