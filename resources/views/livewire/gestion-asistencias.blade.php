<div wire:init="loadAsistencias" x-data="{ filtersOpen: false }">
    <!-- Barra de Búsqueda y Filtros -->
    <div class="flex justify-end items-center mb-4">
        <x-buttons.secondary @click="filtersOpen = !filtersOpen" class="w-full md:w-auto justify-center text-sm" title="Filtros">
            <i class="ph ph-faders text-lg"></i>
            <span class="sm:inline">Filtros</span>
            <i class="ph ph-caret-down text-lg transition-transform" :class="{'rotate-180': filtersOpen}"></i>
        </x-buttons.secondary>
    </div>

    <!-- Filtros Avanzados -->
    <div x-show="filtersOpen" class="mb-6">
        <div class="bg-white p-4 rounded-lg border border-sigedra-border">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Filtro por fecha -->
                <div>
                    <x-input-label for="start_date">Fecha de inicio</x-input-label>
                    <div class="relative mt-1">
                        <x-text-input wire:model.defer="startDate" id="start_date" class="block w-full flatpickr pl-3 pr-10 py-2 border-sigedra-border shadow-sm sm:text-sm" type="text" name="start_date" placeholder="Seleccionar fecha" autocomplete="off" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button x-show="!$wire.startDate" type="button" class="pointer-events-none">
                                <i class="ph ph-calendar text-lg text-gray-400"></i>
                            </button>
                            <button x-show="$wire.startDate" x-on:click="$wire.set('startDate', '')" type="button" class="text-gray-400 hover:text-gray-600">
                                <i class="ph ph-x-circle text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <x-input-label for="end_date">Fecha de fin</x-input-label>
                     <div class="relative mt-1">
                        <x-text-input wire:model.defer="endDate" id="end_date" class="block w-full flatpickr pl-3 pr-10 py-2 border-sigedra-border shadow-sm sm:text-sm" type="text" name="end_date" placeholder="Seleccionar fecha" autocomplete="off" />
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button x-show="!$wire.endDate" type="button" class="pointer-events-none">
                                <i class="ph ph-calendar text-lg text-gray-400"></i>
                            </button>
                            <button x-show="$wire.endDate" x-on:click="$wire.set('endDate', '')" type="button" class="text-gray-400 hover:text-gray-600">
                                <i class="ph ph-x-circle text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filtro por Grado -->
                <div x-data="{ open: false }" class="relative">
                    <x-input-label for="grades">Grado</x-input-label>
                    <button @click="open = !open" type="button" class="relative mt-1 w-full text-left bg-white border border-sigedra-border rounded-md shadow-sm pl-3 pr-10 py-2 focus:outline-none focus:ring-1 focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm flex items-center">
                        <span class="block truncate flex-grow">Seleccionar grados...</span>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                            <i class="ph ph-caret-down text-lg text-gray-400"></i>
                        </span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md border border-sigedra-border" style="display: none;">
                        <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            @foreach($allGrados as $anio => $grados)
                                <li x-data="{ expanded: true }" class="py-1">
                                    <h3 @click="expanded = !expanded" class="flex items-center justify-between px-3 py-2 text-sm font-semibold text-gray-900 cursor-pointer hover:bg-gray-100">
                                        <span>Año {{ $anio }}</span>
                                        <i class="ph ph-caret-down text-lg transition-transform" :class="{'rotate-180': expanded}"></i>
                                    </h3>
                                    <ul x-show="expanded" class="pl-4 mt-1 space-y-1">
                                        @foreach($grados as $grado)
                                            <li>
                                                <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100 rounded-md">
                                                    <input wire:model.defer="selectedGrades" type="checkbox" value="{{ $grado->id }}" class="h-4 w-4 text-sigedra-primary border-gray-300 rounded focus:ring-sigedra-primary">
                                                    <span class="ml-3 block font-normal truncate">{{ $grado->nombre }}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Filtro por Materia -->
                <div x-data="{ open: false }" class="relative">
                    <x-input-label for="subjects">Materia</x-input-label>
                    <button @click="open = !open" type="button" class="relative mt-1 w-full text-left bg-white border border-sigedra-border rounded-md shadow-sm pl-3 pr-10 py-2 focus:outline-none focus:ring-1 focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm flex items-center">
                        <span class="block truncate flex-grow">Seleccionar materias...</span>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                            <i class="ph ph-caret-down text-lg text-gray-400"></i>
                        </span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md border border-sigedra-border" style="display: none;">
                        <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            @foreach($allMaterias as $materia)
                                <li>
                                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                                        <input wire:model.defer="selectedMaterias" type="checkbox" value="{{ $materia->id }}" class="h-4 w-4 text-sigedra-primary border-gray-300 rounded focus:ring-sigedra-primary">
                                        <span class="ml-3 block font-normal truncate">{{ $materia->nombre }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Filtro por Maestro -->
                 <div>
                    <x-input-label for="maestro">Maestro</x-input-label>
                    <select wire:model.defer="selectedMaestro" id="maestro" class="mt-1 block w-full pl-3 pr-10 py-2 border-sigedra-border bg-white rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm">
                        <option value="">Todos los maestros</option>
                        @foreach($allMaestros as $maestro)
                            <option value="{{ $maestro->id }}">{{ $maestro->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <x-buttons.secondary wire:click="clearFilters">Limpiar Filtros</x-buttons.secondary>
                <x-buttons.primary wire:click="applyFilters">Aplicar Filtros</x-buttons.primary>
            </div>
        </div>
    </div>

    <!-- Active Filters Summary -->
    @if(collect($activeFilters)->filter()->isNotEmpty())
    <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg flex items-center justify-between">
        <div class="flex items-center gap-x-3 flex-wrap">
            <span class="font-semibold">Filtros aplicados:</span>
            @if($activeFilters['startDate'] || $activeFilters['endDate'])
                <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">
                    Fecha: {{ $activeFilters['startDate'] ? \Carbon\Carbon::parse($activeFilters['startDate'])->format('d/m/y') : '...' }} - {{ $activeFilters['endDate'] ? \Carbon\Carbon::parse($activeFilters['endDate'])->format('d/m/y') : '...' }}
                </span>
            @endif
            @if(!empty($activeFilters['selectedGrades']))
                 <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">
                    Grados: {{ count($activeFilters['selectedGrades']) }}
                </span>
            @endif
            @if(!empty($activeFilters['selectedMaterias']))
                 <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">
                    Materias: {{ count($activeFilters['selectedMaterias']) }}
                </span>
            @endif
             @if($activeFilters['selectedMaestro'])
                 <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded">
                    Maestro: {{ $allMaestros->firstWhere('id', $activeFilters['selectedMaestro'])->nombre_completo }}
                </span>
            @endif
        </div>
        <button wire:click="clearFilters" class="text-blue-800 hover:text-blue-900 font-semibold text-sm">
            Limpiar todo
        </button>
    </div>
    @endif


    <div class="relative">
        <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity">
            <x-table>
                <x-slot:head>
                    <tr>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Fecha</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Curso</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Grado</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Maestro</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">P</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">T</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">A</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">ASIST. %</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Acciones</th>
                    </tr>
                </x-slot:head>

                <x-slot:body>
                    @if ($isReady)
                        @forelse ($asistencias as $asistencia)
                            <tr wire:key="asistencia-{{ $asistencia->id }}" class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-3 text-base font-medium text-gray-800">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->curso }}">{{ $asistencia->curso }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->grado }}">{{ $asistencia->grado }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->maestro_nombre }}">{{ $asistencia->maestro_nombre }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 text-center">{{ $asistencia->presentes }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 text-center">{{ $asistencia->tardias }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 text-center">{{ $asistencia->ausentes }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 text-center">
                                    @if ($asistencia->total_estudiantes > 0)
                                        {{ round(($asistencia->presentes / $asistencia->total_estudiantes) * 100) }}%
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-base font-medium">
                                    <div class="w-full flex items-center justify-center gap-x-2">
                                        <x-buttons.secondary href="#" title="Ver Detalles">
                                            <i class="ph ph-eye text-lg"></i>
                                        </x-buttons.secondary>
                                        <x-buttons.danger-secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-attendance-deletion-{{ $asistencia->id }}')" title="Eliminar Asistencia">
                                            <i class="ph ph-trash text-lg"></i>
                                        </x-buttons.danger-secondary>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-base text-gray-500">
                                    No se encontraron registros de asistencia que coincidan con los filtros aplicados.
                                </td>
                            </tr>
                        @endforelse
                    @else
                        @for ($i = 0; $i < 5; $i++)
                            <tr wire:key="skeleton-{{ $i }}" class="bg-white animate-pulse">
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-full"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-full"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-full"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="h-4 bg-gray-200 rounded w-1/4 mx-auto"></div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="w-full flex items-center justify-center gap-x-2">
                                        <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                        <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    @endif
                </x-slot:body>
            </x-table>
        </div>
        <div wire:loading.flex class="absolute inset-0 items-center justify-center bg-white bg-opacity-50">
            <i class="ph ph-spinner-gap text-4xl text-sigedra-primary animate-spin"></i>
        </div>
    </div>


    @if ($isReady && $asistencias->hasPages())
        <div class="mt-8">
            {{ $asistencias->links('vendor.pagination.sigedra-pagination') }}
        </div>
    @endif
</div>
