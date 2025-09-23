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
    <x-filters-panel :allGrados="$allGrados" :allMaterias="$allMaterias" :allMaestros="$allMaestros" />

    <!-- Active Filters Summary -->
    <x-active-filters-summary :activeFilters="$activeFilters" :allMaestros="$allMaestros" />

    @if ($isReady)
    <div class="mb-4 text-sm text-gray-600">
        @if (collect($activeFilters)->filter()->isNotEmpty())
            Mostrando <span class="font-bold">{{ $filteredRecords }}</span> registros de un total de <span class="font-bold">{{ $totalRecords }}</span>.
        @else
            Mostrando un total de <span class="font-bold">{{ $totalRecords }}</span> registros.
        @endif
    </div>
    @endif

    <div class="relative">
        <div class="transition-opacity">
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
                            <x-empty-state message="No se encontraron registros de asistencia que coincidan con los filtros aplicados." />
                        @endforelse
                    @else
                        <x-attendance-skeleton-table />
                    @endif
                </x-slot:body>
            </x-table>
        </div>
        <div wire:loading.flex class="absolute inset-0 items-center justify-center bg-white bg-opacity-50">
            <i class="ph ph-spinner-gap text-4xl text-sigedra-primary animate-spin"></i>
        </div>
    </div>


    @if ($isReady)
        <div class="mt-8">
            {{ $asistencias->links('vendor.pagination.sigedra-pagination') }}
        </div>
    @endif
</div>
