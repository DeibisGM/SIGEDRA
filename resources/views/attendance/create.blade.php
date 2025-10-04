{{-- resources/views/attendance/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Crear Asistencia')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('attendance.index') }}" class="hover:text-sigedra-text-dark">Asistencia</a>
    <span class="mx-2">/</span>
    <span>Crear Asistencia</span>
</div>
@endsection

@section('module_title', 'Registro de Asistencia')
@section('module_subtitle', 'Pasa lista para un curso en una fecha específica')

@section('header_actions')
<div class="hidden md:flex gap-3" x-data="{ loading: false }" @loading-start.window="loading = true" @loading-stop.window="loading = false">
    <a href="{{ route('attendance.index') }}">
        <x-secondary-button type="button">Cancelar</x-secondary-button>
    </a>
    <x-primary-loading-button type="submit" form="attendance-form" loading="loading" class="min-w-[200px]">
        <i class="ph ph-floppy-disk text-lg"></i>
        <span>Guardar Asistencia</span>
    </x-primary-loading-button>
</div>
@endsection

@section('footer_actions')
<div class="flex gap-3 w-full" x-data="{ loading: false }" @loading-start.window="loading = true" @loading-stop.window="loading = false">
    <a href="{{ route('attendance.index') }}" class="w-full">
        <x-secondary-button type="button" class="w-full justify-center">Cancelar</x-secondary-button>
    </a>
    <x-primary-loading-button type="submit" form="attendance-form" class="w-full justify-center" loading="loading">
        <i class="ph ph-floppy-disk text-lg"></i>
        <span>Guardar Asistencia</span>
    </x-primary-loading-button>
</div>
@endsection

@section('content')
    @include('attendance._form', [
        'formAction' => route('attendance.store'),
        'cargaAcademica' => $cargaAcademica,
        'students' => $students,
        'fecha' => $fecha,
        'ciclo_id' => $ciclo_id,
        'cicloNombre' => $cicloNombre,
    ])
@endsection