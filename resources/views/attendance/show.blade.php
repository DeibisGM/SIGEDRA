@extends('layouts.app')

@section('title', 'Visualizar Asistencia')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('attendance.index', $backFilters) }}" class="hover:text-gray-700">Asistencia</a>
    <span class="mx-2">/</span>
    <span>Visualizar Asistencia</span>
</div>
@endsection

@section('module_title')
<div class="flex flex-col md:flex-row md:items-baseline md:gap-x-4">
    <h1 class="text-2xl font-bold text-sigedra-primary">Detalle de la Sesión de Asistencia</h1>
    <span class="text-base text-sigedra-text-medium">
        {{ \Carbon\Carbon::parse($sesion->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
    </span>
</div>
@endsection

@section('header_actions')
<div class="hidden md:flex gap-3">
    <x-buttons.secondary href="{{ route('attendance.index', $backFilters) }}">
        <i class="ph ph-arrow-left text-lg"></i>
        <span>Volver</span>
    </x-buttons.secondary>
</div>
@endsection

@section('footer_actions')
<div class="flex gap-3 w-full">
    <x-buttons.secondary href="{{ route('attendance.index', $backFilters) }}" class="w-full justify-center">
        <i class="ph ph-arrow-left text-lg"></i>
        <span>Volver</span>
    </x-buttons.secondary>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-details-field label="Curso" value="{{ $sesion->subject }}" />
        <x-details-field label="Grado" value="{{ $sesion->nivel_academico_nombre }} {{ $sesion->anio_lectivo_anio }}" />
        <x-details-field label="Maestro" value="{{ $sesion->maestro_nombre }}" />
    </div>

    <!-- Tabla de Estudiantes -->
    <x-table class="-mx-4 md:mx-0">
        <x-slot:head>
            <tr>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">#</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Cédula</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]">Nombre completo</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Estado</th>
                <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[35%]">Observaciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @forelse ($students as $student)
            <tr class="bg-white hover:bg-gray-50">
                <td class="px-6 py-3 text-base font-medium text-gray-800">{{ $loop->iteration }}</td>
                <td class="px-6 py-3 text-base text-gray-800">{{ $student->cedula }}</td>
                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $student->nombre_completo }}">{{ $student->nombre_completo }}</td>
                <td class="px-6 py-3 text-base text-gray-800">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                        @switch($student->estado)
                            @case('Presente') bg-green-100 text-green-800 @break
                            @case('Ausente') bg-red-100 text-red-800 @break
                            @case('Tardía') bg-yellow-100 text-yellow-800 @break
                            @default bg-gray-100 text-gray-800
                        @endswitch
                    ">
                        {{ $student->estado }}
                    </span>
                </td>
                <td class="px-6 py-3 text-base text-gray-800">{{ $student->observaciones ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-3 text-center text-sm text-sigedra-text-medium">No hay estudiantes registrados en esta sesión de asistencia.</td>
            </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>
@endsection
