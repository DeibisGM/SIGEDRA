 @extends('layouts.app')

    @section('title', 'Gestión de Asistencia')

    @section('content')
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                Módulo de Asistencia
            </h1>
            <a href="{{ route('home') }}" class="text-blue-500 hover:underline">
                &larr; Volver al inicio
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <p class="text-gray-700 dark:text-gray-300">
                Aquí se implementará la funcionalidad para pasar asistencia.
            </p>
        </div>
    @endsection
