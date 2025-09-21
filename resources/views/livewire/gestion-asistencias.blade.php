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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Filtro por fecha -->
                <div>
                    <x-input-label for="start_date">Fecha de inicio</x-input-label>
                    <x-text-input wire:model.defer="startDate" id="start_date" class="block mt-1 w-full flatpickr" type="text" name="start_date" placeholder="Seleccionar fecha de inicio" />
                </div>
                <div>
                    <x-input-label for="end_date">Fecha de fin</x-input-label>
                    <x-text-input wire:model.defer="endDate" id="end_date" class="block mt-1 w-full flatpickr" type="text" name="end_date" placeholder="Seleccionar fecha de fin" />
                </div>

                <!-- Filtro por Grado -->
                <div x-data="{ open: false }" class="relative">
                    <x-input-label for="grades">Grado</x-input-label>
                    <button @click="open = !open" type="button" class="relative mt-1 w-full text-left bg-white border border-sigedra-border rounded-md shadow-sm pl-3 pr-10 py-2 focus:outline-none focus:ring-1 focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm flex items-center">
                        <span class="block truncate flex-grow">
                            @if (empty($selectedGrades))
                                Todos los grados
                            @else
                                {{ count($selectedGrades) }} grados seleccionados
                            @endif
                        </span>
                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                            <i class="ph ph-caret-down text-lg text-gray-400"></i>
                        </span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md border border-sigedra-border" style="display: none;">
                        <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                            @foreach($allGrados as $grado)
                                <li>
                                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                                        <input wire:model.defer="selectedGrades" type="checkbox" value="{{ $grado->id }}" class="h-4 w-4 text-sigedra-primary border-gray-300 rounded focus:ring-sigedra-primary">
                                        <span class="ml-3 block font-normal truncate">{{ $grado->nombre }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Filtro por Materia -->
                <div x-data="{ open: false }" class="relative">
                    <x-input-label for="subjects">Materia</x-input-label>
                    <button @click="open = !open" type="button" class="relative mt-1 w-full text-left bg-white border border-sigedra-border rounded-md shadow-sm pl-3 pr-10 py-2 focus:outline-none focus:ring-1 focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm flex items-center">
                        <span class="block truncate flex-grow">
                             @if (empty($selectedMaterias))
                                Todas las materias
                            @else
                                {{ count($selectedMaterias) }} materias seleccionadas
                            @endif
                        </span>
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
            </div>
            <div class="flex justify-end gap-3 mt-4">
                <x-buttons.secondary wire:click="clearFilters">Limpiar Filtros</x-buttons.secondary>
                <x-buttons.primary wire:click="applyFilters">Aplicar Filtros</x-buttons.primary>
            </div>
        </div>
    </div>


    <div class="relative">
        <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity">
            <x-table>
                <x-slot:head>
                    <tr>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Fecha</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[20%]">Curso</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[20%]">Grado</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Presentes</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Tardías</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Ausentes</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">ASIST. %</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Acciones</th>
                    </tr>
                </x-slot:head>

                <x-slot:body>
                    @if ($isReady)
                        @forelse ($asistencias as $asistencia)
                            <tr wire:key="asistencia-{{ $asistencia->id }}" class="bg-white hover:bg-gray-50">
                                <td class="px-6 py-3 text-base font-medium text-gray-800">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->curso }}">{{ $asistencia->curso }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->grado }}">{{ $asistencia->grado }}</td>
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
                                <td colspan="8" class="px-6 py-8 text-center text-base text-gray-500">
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
