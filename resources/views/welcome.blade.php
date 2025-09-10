@extends('layouts.app')

@section('title', 'Dashboard')
@section('module_title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Grid de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-card
            title="Estudiantes Presentes"
            body="34"
            variant="accent"
        />
        <x-card
            title="Clases para Hoy"
            body="5"
            variant="default"
        />
        <x-card
            title="Avisos Pendientes"
            body="1"
            variant="default"
        />
    </div>

    <!-- Sección de Accesos Rápidos -->
    <div>
        <h2 class="text-2xl font-bold text-sigedra-text-dark mb-4">Accesos Rápidos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('attendance.index') }}" class="block p-6 bg-sigedra-card rounded-lg border border-sigedra-border hover:border-sigedra-primary transition-colors duration-300">
                <h3 class="font-bold text-xl text-sigedra-secondary">Pasar Asistencia</h3>
                <p class="mt-2 text-sigedra-text-medium">Registra la asistencia diaria de tus cursos.</p>
            </a>
            <a href="#" class="block p-6 bg-sigedra-card rounded-lg border border-sigedra-border hover:border-sigedra-primary transition-colors duration-300">
                <h3 class="font-bold text-xl text-sigedra-secondary">Generar Reportes</h3>
                <p class="mt-2 text-sigedra-text-medium">Consulta y exporta informes de asistencia.</p>
            </a>
            <a href="#" class="block p-6 bg-sigedra-card rounded-lg border border-sigedra-border hover:border-sigedra-primary transition-colors duration-300">
                <h3 class="font-bold text-xl text-sigedra-secondary">Gestionar Estudiantes</h3>
                <p class="mt-2 text-sigedra-text-medium">Accede a los perfiles de los estudiantes.</p>
            </a>
        </div>
    </div>
</div>
@endsection
