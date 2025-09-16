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

@section('content')
    <div class="text-center">
        <h2 class="text-2xl">Módulo de Estudiantes</h2>
        <p class="text-lg text-gray-600">Contenido del módulo de estudiantes.</p>
    </div>
@endsection
