@extends('layouts.pdf-preview-layout')

@section('title', 'Vista de Impresión')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <span>Estudiantes</span>
    <span class="mx-2">/</span>
    <span class="font-semibold text-sigedra-primary">Reporte Académico</span>
</div>
@endsection

@section('module_title', 'Reporte Académico del Estudiante')
@section('module_subtitle', 'Este es un ejemplo de cómo se vería el reporte para exportar a PDF.')

@section('content')
<div class="bg-white border border-sigedra-border rounded-lg shadow-sm p-6 space-y-6">

    {{-- Información del Estudiante --}}
    <div>
        <h3 class="text-lg font-bold text-sigedra-primary">Estudiante: {{ $student['nombre_completo'] }}</h3>
        <p class="text-sm text-sigedra-text-medium">Cédula: {{ $student['cedula'] }}</p>
        <p class="text-sm text-sigedra-text-medium">Grado: {{ $student['grado_actual'] }}</p>
    </div>

    {{-- Tabla de Notas --}}
    <div class="border rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-sigedra-border">
            <thead class="bg-sigedra-input">
            <tr>
                <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Materia</th>
                <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Profesor</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Promedio Final</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Estado</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-sigedra-border bg-white">
            @foreach($courses as $course)
            <tr>
                <td class="px-6 py-4 font-medium text-gray-800">{{ $course['materia'] }}</td>
                <td class="px-6 py-4 text-gray-700">{{ $course['profesor'] }}</td>
                <td class="px-6 py-4 text-center font-bold text-gray-800">{{ $course['promedio'] }}</td>
                <td class="px-6 py-4 text-center">
                    <span @class([
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    'bg-green-100 text-green-800' => $course['estado'] === 'Aprobado',
                    'bg-red-100 text-red-800' => $course['estado'] === 'Reprobado',
                    ])>
                    {{ $course['estado'] }}
                    </span>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pie de página del reporte --}}
    <div class="pt-4 border-t border-dashed">
        <p class="text-xs text-center text-gray-500">
            Reporte generado por SIGEDRA el {{ now()->translatedFormat('d \d\e F \d\e Y \a \l\a\s h:i A') }}.
        </p>
    </div>
</div>
@endsection
