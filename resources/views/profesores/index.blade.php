@extends('layouts.app')

@section('title', 'Profesores')

@section('breadcrumbs')
    <div class="text-base text-gray-500">
        <a href="{{ route('profesores.index') }}" class="hover:text-gray-700">Profesores</a>
        <span class="mx-2">/</span>
        <span>Gestión de Profesores</span>
    </div>
@endsection

@section('module_title', 'Gestión de Profesores')

@section('content')
    <div class="text-center">
        <h2 class="text-2xl">Módulo de Profesores</h2>
        <p class="text-lg text-gray-600">Contenido del módulo de profesores.</p>
    </div>
@endsection
