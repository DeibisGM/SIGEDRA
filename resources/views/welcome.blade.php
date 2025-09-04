@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-4xl mx-auto text-center">
        <!-- Hero Section -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-4">
                Bienvenido a <span class="text-blue-600">SIGEDRA</span>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                Sistema Integral de Gestión de Documentos y Recursos Administrativos
            </p>
        </div>

<figure class="diff aspect-16/9" tabindex="0">
  <div class="diff-item-1" role="img" tabindex="0">
    <img alt="daisy" src="https://img.daisyui.com/images/stock/photo-1560717789-0ac7c58ac90a.webp" />
  </div>
  <div class="diff-item-2" role="img">
    <img
      alt="daisy"
      src="https://img.daisyui.com/images/stock/photo-1560717789-0ac7c58ac90a-blur.webp" />
  </div>
  <div class="diff-resizer"></div>
</figure>

<x-card title="Alumno destacado" body="Juan Pérez tiene 100 en matemáticas" variant="primary" />
<x-card title="Alumno normal" body="Ana Gómez tiene 85 en historia" />
<x-card title="Alumno destacado" body="Juan Pérez tiene 100 en matemáticas" variant="success" />



    <x-tarjeta-alumno nombre="Ana Gómez" materia="Historia" nota="85" />
    <x-tarjeta-alumno nombre="Juan" materia="Historia" nota="85" />



<div class="flex gap-x-3" data-hs-pin-input="">
  <input type="text" class="block w-9.5 text-center bg-gray-200 border-transparent rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="⚬" data-hs-pin-input-item="">
  <input type="text" class="block w-9.5 text-center bg-gray-200 border-transparent rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="⚬" data-hs-pin-input-item="">
  <input type="text" class="block w-9.5 text-center bg-gray-200 border-transparent rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="⚬" data-hs-pin-input-item="">
  <input type="text" class="block w-9.5 text-center bg-gray-200 border-transparent rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-transparent dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="⚬" data-hs-pin-input-item="">
</div>
@endsection
