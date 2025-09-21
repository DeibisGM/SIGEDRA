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
    <div x-show="filtersOpen" x-collapse class="mb-6">
        <div class="bg-white p-4 rounded-lg border border-sigedra-border">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Filtro por fecha -->
                <div>
                    <x-input-label for="start_date">Fecha de inicio</x-input-label>
                    <x-text-input wire:model.lazy="startDate" id="start_date" class="block mt-1 w-full" type="date" name="start_date" />
                </div>
                <div>
                    <x-input-label for="end_date">Fecha de fin</x-input-label>
                    <x-text-input wire:model.lazy="endDate" id="end_date" class="block mt-1 w-full" type="date" name="end_date" />
                </div>
                <!-- Filtro por Grado -->
                <div>
                    <x-input-label for="grades">Grado</x-input-label>
                    <select wire:model.lazy="selectedGrades" id="grades" multiple class="mt-1 block w-full py-2 px-3 border border-sigedra-border bg-white rounded-md shadow-sm focus:outline-none focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm">
                        @foreach($allGrados as $grado)
                            <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Filtro por Materia -->
                <div>
                    <x-input-label for="subjects">Materia</x-input-label>
                    <select wire:model.lazy="selectedMaterias" id="subjects" multiple class="mt-1 block w-full py-2 px-3 border border-sigedra-border bg-white rounded-md shadow-sm focus:outline-none focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm">
                        @foreach($allMaterias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
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


    <x-table>
        <x-slot:head>
            <tr>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Fecha</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[20%]">Curso</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[20%]">Grado</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Presentes</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Tardías</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Ausentes</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Asistencia %</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Acciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @if ($isReady)
                @forelse ($asistencias as $asistencia)
                    <tr wire:key="asistencia-{{ $asistencia->id }}" class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 text-base font-medium text-gray-800">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 truncate" title="{{ $asistencia->curso }}">{{ $asistencia->curso }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 truncate" title="{{ $asistencia->grado }}">{{ $asistencia->grado }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $asistencia->presentes }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $asistencia->tardias }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $asistencia->ausentes }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">
                            @if ($asistencia->total_estudiantes > 0)
                                {{ round(($asistencia->presentes / $asistencia->total_estudiantes) * 100) }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td class="px-6 py-4 text-base font-medium">
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
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="h-4 bg-gray-200 rounded w-1/4 mx-auto"></div>
                        </td>
                        <td class="px-6 py-4">
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

    @if ($isReady && $asistencias->hasPages())
        <div class="mt-8">
            {{ $asistencias->links('vendor.pagination.sigedra-pagination') }}
        </div>
    @endif
</div>
