@extends('layouts.app')

@section('title', 'Estudiantes')

@section('breadcrumbs')
    <div class="text-base text-gray-500 whitespace-nowrap truncate">
        <a href="{{ route('estudiantes.index') }}" class="hover:text-gray-700">Estudiantes</a>
        <span class="mx-2">/</span>
        <span>Gestión de Estudiantes</span>
    </div>
@endsection

@section('module_title', 'Gestión de Estudiantes')
@section('module_subtitle', 'Administra los estudiantes de tus cursos.')

@section('header_actions')
    <div class="hidden md:flex items-center gap-3">
        <!-- Grade and Year Selectors -->
        <form action="{{ route('estudiantes.index') }}" method="GET" class="flex items-center gap-3">
            <select name="grado_id" id="grado_id" onchange="this.form.submit()" class="py-2 px-4 block w-full bg-white border-sigedra-border rounded-lg text-sm focus:border-sigedra-primary focus:ring-sigedra-primary">
                <option value="">Todos los Grados</option>
                @foreach($grados as $grado)
                    <option value="{{ $grado->id }}" @selected(request('grado_id') == $grado->id)>{{ $grado->nivelAcademico->nombre }}</option>
                @endforeach
            </select>

            <select name="anio_academico_id" id="anio_academico_id" onchange="this.form.submit()" class="py-2 px-4 block w-full bg-white border-sigedra-border rounded-lg text-sm focus:border-sigedra-primary focus:ring-sigedra-primary">
                <option value="">Todos los Años</option>
                @foreach($aniosAcademicos as $anio)
                    <option value="{{ $anio->id }}" @selected(request('anio_academico_id') == $anio->id)>{{ $anio->anio }}</option>
                @endforeach
            </select>
        </form>

        <div class="flex-grow"></div>

        <!-- Create Student Button -->
        <x-buttons.primary as="a" href="{{ route('estudiantes.create') }}">
            <i class="ph ph-plus-circle text-lg"></i>
            <span class="ms-2">Crear Estudiante</span>
        </x-buttons.primary>

        <!-- More Actions Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <x-buttons.secondary @click="open = !open" class="flex items-center px-3">
                <span class="sr-only">Más acciones</span>
                <i class="ph ph-dots-three-vertical text-lg"></i>
            </x-buttons.secondary>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-20"
                 style="display: none;">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <a href="#" class="flex items-center gap-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        <i class="ph ph-download-simple text-lg text-gray-500"></i>
                        <span>Descargar Plantilla</span>
                    </a>
                    <a href="#" class="flex items-center gap-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                        <i class="ph ph-upload-simple text-lg text-gray-500"></i>
                        <span>Cargar Plantilla</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Barra de Búsqueda y Filtros -->
    <div class="flex flex-col md:flex-row gap-3 justify-between items-center">
        <div class="relative w-full md:w-auto md:flex-1">
            <input type="text" class="py-2 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar por cédula, nombre, etc...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
        <div class="flex gap-3 w-full md:w-auto justify-end">
            <x-buttons.secondary class="w-full md:w-auto justify-center text-sm" title="Filtros">
                <i class="ph ph-faders text-lg"></i>
                <span class="sm:inline">Filtros</span>
            </x-buttons.secondary>
        </div>
    </div>

    <!-- Student Table -->
    <x-table>
        <x-slot:head>
            <tr>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Cédula</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Nombre completo</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Edad</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Género</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Dirección</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Acciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @foreach ($estudiantes as $estudiante)
                <tr class="bg-white hover:bg-gray-50">
                    <td class="px-6 py-4 text-base font-medium text-gray-800">{{ $estudiante->cedula }}</td>
                    <td class="px-6 py-4 text-base text-gray-800">{{ $estudiante->nombre_completo }}</td>
                    <td class="px-6 py-4 text-base text-gray-800 text-center">{{ \Carbon\Carbon::parse($estudiante->fecha_nacimiento)->age }}</td>
                    <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $estudiante->genero }}</td>
                    <td class="px-6 py-4 text-base text-gray-800" title="{{ $estudiante->direccion }}">{{ $estudiante->direccion }}</td>
                    <td class="px-6 py-4 text-base font-medium">
                        <div class="w-full flex items-center justify-center gap-x-2">
                            <x-buttons.secondary href="{{ route('estudiantes.show', ['id' => $estudiante->id]) }}" title="Ver Detalles del Estudiante">
                                <i class="ph ph-eye text-lg"></i>
                            </x-buttons.secondary>
                            <x-buttons.secondary href="#" title="Ver Información de Encargados del Estudiante">
                                <i class="ph ph-users-three text-lg"></i>
                            </x-buttons.secondary>
                            <x-buttons.secondary href="#" title="Editar Estudiante">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </x-buttons.secondary>
                            <x-buttons.danger-secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-student-deletion')" title="Eliminar Estudiante">
                                <i class="ph ph-trash text-lg"></i>
                            </x-buttons.danger-secondary>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot:body>
    </x-table>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-student-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                ¿Estás seguro de que deseas eliminar este estudiante?
            </h2>

            <p class="mt-1 text-base text-gray-600">
                Toda la información del estudiante, incluyendo asistencias y notas, será eliminada permanentemente. Esta acción no se puede deshacer.
            </p>

            <div class="mt-6 flex justify-end">
                <x-buttons.secondary x-on:click="$dispatch('close')">
                    Cancelar
                </x-buttons.secondary>

                <x-danger-button class="ms-3" x-on:click="$dispatch('close')">
                    Eliminar Estudiante
                </x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
@endsection
