@extends('layouts.app')

@section('title', 'Reportes')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('reportes.index') }}" class="hover:text-gray-700">Reportes</a>
    <span class="mx-2">/</span>
    <span>Análisis de Grado</span>
</div>
@endsection

@section('module_title', 'Reportes y Análisis')
@section('module_subtitle', 'Visualiza el rendimiento y la asistencia de los grados académicos.')

@section('header_actions')
<div class="hidden md:flex items-center gap-3">
    <!-- Selector de Grado -->
    <div x-data="{ open: false }" class="relative">
        <x-buttons.secondary @click="open = !open" class="flex items-center">
            <i class="ph ph-graduation-cap text-lg"></i>
            <span class="ms-2">Cuarto Grado</span>
            <span class="text-xs text-gray-400 ms-1.5">({{ now()->year }})</span>
            <i class="ph ph-caret-down text-sm ms-2"></i>
        </x-buttons.secondary>
        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-20" style="display: none;">
            <div class="py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Primer Grado</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Segundo Grado</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tercer Grado</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 bg-gray-100">Cuarto Grado</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Quinto Grado</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sexto Grado</a>
            </div>
        </div>
    </div>

    <!-- Botón de Exportar -->
    <div x-data="{ open: false }" class="relative">
        <x-buttons.primary @click="open = !open">
            <i class="ph ph-download-simple text-lg"></i>
            <span class="ms-2">Exportar</span>
            <i class="ph ph-caret-down text-sm ms-2"></i>
        </x-buttons.primary>
        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-20" style="display: none;">
            <div class="py-1">
                <a href="#" class="flex items-center gap-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="ph ph-file-pdf text-lg text-red-500"></i><span>Exportar a PDF</span>
                </a>
                <a href="#" class="flex items-center gap-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <i class="ph ph-file-xls text-lg text-green-600"></i><span>Exportar a Excel</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Métricas Principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <x-card title="Total de Estudiantes" body="{{ $metrics['total_students'] }}" />
        <x-card title="Asistencia Promedio" body="{{ $metrics['average_attendance'] }}%" />
        <x-card title="Estudiantes Aprobados" body="{{ $metrics['approved_students'] }}" variant="primary" />
        <x-card title="Estudiantes en Riesgo" body="{{ $metrics['at_risk_students'] }}" variant="secondary" />
    </div>

    <!-- Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="lg:col-span-3 bg-white border border-sigedra-border rounded-lg p-6">
            <h3 class="text-lg font-bold text-sigedra-primary mb-4">Asistencia Mensual (%)</h3>
            <div class="relative min-h-[350px]">
                <canvas id="attendanceChart" data-attendance='@json($attendanceData)'></canvas>
            </div>
        </div>
        <div class="lg:col-span-2 bg-white border border-sigedra-border rounded-lg p-6">
            <h3 class="text-lg font-bold text-sigedra-primary mb-4">Distribución de Notas</h3>
            <div class="relative min-h-[350px] flex justify-center">
                <canvas id="gradesChart" data-grades='@json($gradesData)'></canvas>
            </div>
        </div>
    </div>

    <!-- Listas de Estudiantes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Estudiantes con más ausencias -->
        <div class="bg-white border border-sigedra-border rounded-lg">
            <h3 class="text-lg font-bold text-sigedra-primary p-6">Estudiantes con Más Ausencias</h3>
            <x-table class="md:border-t">
                <x-slot:head>
                    <tr>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase">Nombre</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase">Ausencias</th>
                    </tr>
                </x-slot:head>
                <x-slot:body>
                    @foreach($topAbsences as $student)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $student['nombre'] }}</td>
                        <td class="px-6 py-3 text-center font-bold text-sigedra-error">{{ $student['ausencias'] }}</td>
                    </tr>
                    @endforeach
                </x-slot:body>
            </x-table>
        </div>

        <!-- Estudiantes en Riesgo -->
        <div class="bg-white border border-sigedra-border rounded-lg">
            <h3 class="text-lg font-bold text-sigedra-primary p-6">Estudiantes en Riesgo Académico</h3>
            <x-table class="md:border-t">
                <x-slot:head>
                    <tr>
                        <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase">Nombre</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase">Promedio</th>
                    </tr>
                </x-slot:head>
                <x-slot:body>
                    @foreach($atRiskStudents as $student)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $student['nombre'] }}</td>
                        <td class="px-6 py-3 text-center font-bold text-sigedra-warning">{{ $student['promedio'] }}</td>
                    </tr>
                    @endforeach
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
@endsection


