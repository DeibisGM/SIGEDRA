@extends('layouts.app')

@section('title', 'Inicio')
@section('module_title', 'Inicio')

@section('content')
    <div class="py-5">
        <h2 class="text-2xl font-bold text-sigedra-text-dark">Buenas, {{ Auth::user()->name }}!</h2>
    </div>
    <x-dashboard-skeleton />
@endsection
