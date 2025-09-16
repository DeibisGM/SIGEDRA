@extends('layouts.app')

@section('title', 'Reportes')

@section('breadcrumbs')
    <div class="text-base text-gray-500 whitespace-nowrap truncate">
        <a href="{{ route('reportes.index') }}" class="hover:text-gray-700">Reportes</a>
        <span class="mx-2">/</span>
        <span>Generación de Reportes</span>
    </div>
@endsection

@section('module_title', 'Generación de Reportes')

@section('content')
    <div class="text-center">
        <h2 class="text-2xl">Módulo de Reportes</h2>
        <p class="text-lg text-gray-600">Contenido del módulo de reportes.</p>
    </div>
@endsection
