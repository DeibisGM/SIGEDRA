@extends('layouts.app')

@section('title', 'Maestros')

@section('breadcrumbs')
<div class="text-base text-gray-500 whitespace-nowrap truncate">
    <a href="{{ route('maestros.index') }}" class="hover:text-gray-700">Maestros</a>
    <span class="mx-2">/</span>
    <span>Gestión de Maestros</span>
</div>
@endsection

@section('module_title', 'Gestión de Maestros')
@section('module_subtitle', 'Administra los maestros de la institución.')

@section('header_actions')
<div class="hidden md:flex items-center gap-3">
    <div class="flex-grow"></div>

     <x-primary-button as="a" href="{{ route('maestros.create') }}">

        <i class="ph ph-plus-circle text-lg"></i>
        <span class="ms-2">Crear Maestro</span>
    </x-primary-button>
</div>
@endsection

@section('content')
@livewire('gestion-maestros')
@endsection

@section('footer_actions')
<div class="md:hidden">
    <x-primary-button as="a" href="{{ route('maestros.create') }}" class="w-full justify-center">
        <i class="ph ph-plus-circle text-lg"></i>
        <span class="ms-2">Crear Maestro</span>
    </x-primary-button>
</div>
@endsection
