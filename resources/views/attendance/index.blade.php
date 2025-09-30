@extends('layouts.app')

@section('title', 'Asistencia')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('attendance.index') }}" class="hover:text-sigedra-text-dark">Asistencia</a>
    <span class="mx-2">/</span>
    <span>Historial de asistencia</span>
</div>
@endsection

@section('module_title', 'Historial de Asistencias')
@section('module_subtitle', 'Consulta el historial de las asistencias en el sistema')

@section('header_actions')
<div class="hidden md:flex">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
    >
        <i class="ph ph-plus-circle text-lg"></i>
        <span>Pasar Nueva Asistencia</span>
    </x-primary-button>
</div>
@endsection

@section('footer_actions')
<x-primary-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
    class="w-full md:hidden py-3"
>
    <i class="ph ph-plus-circle text-lg"></i>
    <span>Pasar Nueva Asistencia</span>
</x-primary-button>
@endsection

@section('content')
<div
    class="space-y-6"
    x-data="{ viewingSession: false }"
    @view-session.window="viewingSession = true"
    @close-session.window="viewingSession = false"
>
    <div x-show="!viewingSession" x-transition.opacity.duration.300ms>
        @livewire('attendance.attendance-history')
    </div>

    <div x-show="viewingSession" x-transition.opacity.duration.300ms style="display: none;">
        @livewire('attendance.session-detail')
    </div>

    <x-pre-create-modal x-cloak />
</div>
@endsection
