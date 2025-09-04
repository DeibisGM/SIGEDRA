@extends('layouts.app')

@section('title', 'Bienvenido a SIGEDRA')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Bienvenido a <span class="text-primary">SIGEDRA</span>
        </h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto">
            Sistema Integral de Gestión de Documentos y Recursos Administrativos
        </p>
    </div>

    <!-- Módulos del Sistema -->
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Módulos Disponibles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Módulo de Asistencia -->
            <a href="{{ route('attendance.index') }}" class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center gap-4">
                    <!-- Icono -->
                    <div class="bg-primary/10 p-3 rounded-full">
                        <svg class="w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">Gestión de Asistencia</h3>
                        <p class="text-gray-600 text-sm">Registrar y consultar la asistencia.</p>
                    </div>
                </div>
            </a>


        </div>
    </div>
</div>
@endsection
