@extends('layouts.app')

@section('title', 'Asistencia')

@section('breadcrumbs')
    <div class="text-base text-gray-500 whitespace-nowrap truncate">
        <a href="{{ route('attendance.index') }}" class="hover:text-gray-700">Asistencia</a>
        <span class="mx-2">/</span>
        <span>Historial de asistencia</span>
    </div>
@endsection

@section('module_title', 'Historial de Asistencias')
@section('module_subtitle', 'Consulta el historial de las asistencias en el sistema')

@section('header_actions')
    <div class="hidden md:flex">
        <x-buttons.primary
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
        >
            <i class="ph ph-plus-circle text-lg"></i>
            <span>Pasar Nueva Asistencia</span>
        </x-buttons.primary>
    </div>
@endsection

@section('footer_actions')
    <x-buttons.primary
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
        class="w-full md:hidden"
    >
        <i class="ph ph-plus-circle text-lg"></i>
        <span>Pasar Nueva Asistencia</span>
    </x-buttons.primary>
@endsection

@section('content')
    <div class="space-y-6">
        @livewire('gestion-asistencias')

        <x-pre-create-modal x-cloak />
    </div>
@endsection
