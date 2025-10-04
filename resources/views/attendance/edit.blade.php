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
<div class="hidden md:flex gap-3" x-data="{ saveLoading: false, cancelLoading: false }" @loading-stop.window="saveLoading = false">
    <x-secondary-loading-button type="button" loading="cancelLoading" @click="cancelLoading = true; window.location.href='{{ route('attendance.index') }}'">
        Cancelar
    </x-secondary-loading-button>
    <x-primary-loading-button type="submit" form="attendance-form" loading="saveLoading" @click="saveLoading = true" class="min-w-[200px]">
        <i class="ph ph-floppy-disk text-lg"></i>
        <span>Actualizar Asistencia</span>
    </x-primary-loading-button>
</div>
@endsection

@section('footer_actions')
<div class="flex gap-3 w-full" x-data="{ saveLoading: false, cancelLoading: false }" @loading-stop.window="saveLoading = false">
    <x-secondary-loading-button type="button" class="w-full justify-center" loading="cancelLoading" @click="cancelLoading = true; window.location.href='{{ route('attendance.index') }}'">
        Cancelar
    </x-secondary-loading-button>
    <x-primary-loading-button type="submit" form="attendance-form" class="w-full justify-center" loading="saveLoading" @click="saveLoading = true">
        <i class="ph ph-floppy-disk text-lg"></i>
        <span>Actualizar</span>
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
