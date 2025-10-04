{{-- resources/views/attendance/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Editar Asistencia')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('attendance.index') }}" class="hover:text-sigedra-text-dark">Asistencia</a>
    <span class="mx-2">/</span>
    <span>Editar Asistencia</span>
</div>
@endsection

@section('module_title', 'Editar Registro de Asistencia')
@section('module_subtitle', 'Actualiza la lista de asistencia para un curso en una fecha específica')

@section('header_actions')
<div class="hidden md:flex gap-3" x-data="{ loading: false }" @loading-start.window="loading = true" @loading-stop.window="loading = false">
    <a href="{{ route('attendance.index') }}">
        <x-secondary-button type="button">Cancelar</x-secondary-button>
    </a>
    <x-primary-loading-button type="submit" form="attendance-form" loading="loading" class="min-w-[200px]">
        <i class="ph ph-floppy-disk text-lg"></i>
        <span>Actualizar Asistencia</span>
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
        <span>Actualizar Asistencia</span>
    </x-primary-loading-button>
</div>
@endsection

@section('content')
    @include('attendance._form', [
        'formAction' => route('attendance.update', $sesionAsistencia->id),
        'formMethod' => 'PUT',
        'sesionAsistencia' => $sesionAsistencia,
        'cargaAcademica' => $sesionAsistencia->cargaAcademica,
        'fecha' => $sesionAsistencia->fecha->format('Y-m-d'),
        'ciclo_id' => $sesionAsistencia->ciclo_id,
        'cicloNombre' => $sesionAsistencia->ciclo->tipoCiclo->nombre,
    ])
@endsection
