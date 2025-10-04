{{-- resources/views/attendance/index.blade.php --}}

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
    @if(auth()->user()->hasRole('Administrador'))
        <x-primary-button>
            <i class="ph ph-export text-base"></i>
            <span>Exportar Datos</span>
        </x-primary-button>
    @else
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
        >
            <i class="ph ph-plus text-base"></i>
            <span>Pasar Nueva Asistencia</span>
        </x-primary-button>
    @endif

</div>
@endsection

@section('footer_actions')
@endsection

@section('content')

<div
    class=""
    x-data="{ viewingSession: false, sessionId: null }"
    x-init="$watch('viewingSession', value => $dispatch('view-changed', { isViewingSession: value, sessionId: sessionId }))"
    @view-session.window="viewingSession = true; sessionId = $event.detail.sessionId"
    @close-session.window="viewingSession = false; sessionId = null"
>
    <div x-show="!viewingSession">
        @livewire('attendance.attendance-history')
    </div>

    <div x-show="viewingSession" style="display: none;">
        @livewire('attendance.session-detail')
    </div>

    <x-pre-create-modal :cargasAcademicas="$cargasAcademicas" :tiposCiclo="$tiposCiclo" x-cloak class="mt-6" />
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const breadcrumbsContainer = document.getElementById('breadcrumbs-container');
        const originalBreadcrumbs = breadcrumbsContainer.innerHTML;

        window.addEventListener('view-session', event => {
            const sessionId = event.detail.sessionId;
            breadcrumbsContainer.innerHTML = `
                <a href="{{ route('attendance.index') }}" class="hover:text-sigedra-text-dark">Asistencia</a>
                <span class="mx-2">/</span>
                <span>Sesión</span>
                <span class="mx-2">/</span>
                <span>${sessionId}</span>
            `;
        });

        window.addEventListener('close-session', () => {
            breadcrumbsContainer.innerHTML = originalBreadcrumbs;
        });
    });
</script>
@endsection
