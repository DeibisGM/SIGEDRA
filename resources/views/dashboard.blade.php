@extends('layouts.app')

@section('breadcrumbs')
{{-- Agregamos 'flex' para alinear los hijos en una fila y 'items-center' para centrarlos verticalmente --}}
<a href="{{ route('dashboard') }}" class="font-semibold gap-2 text-sigedra-text-medium hover:text-sigedra-primary flex items-center">
    Inicio
    {{-- Este div ahora se comportará como un item de flex y se pondrá al lado --}}
    <div class="px-2 bg-sigedra-primary/10 rounded-full">
        @if(Auth::user()->hasRole('Administrador'))
        <span class="!font-normal">Administrador</span>
        @elseif(Auth::user()->hasRole('Maestro'))
        <span class="!font-normal">Maestro</span>
        @endif
    </div>
</a>
@endsection

@section('content')
    <div class="py-5">
        <h2 class="text-2xl font-bold text-sigedra-text-dark">Buenas <i class="ph-fill ph-sparkle text-2xl"></i>, {{ Auth::user()->name }}!</h2>
    </div>
    <x-dashboard-skeleton />
@endsection
