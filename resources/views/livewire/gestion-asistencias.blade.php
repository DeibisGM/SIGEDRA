<div wire:init="loadAsistencias" x-data="{ filtersOpen: false }" class="relative">
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
    <div class="mb-4 bg-gray-100 border border-gray-200 text-gray-800 px-4 py-3 rounded-lg">
        @if (collect($activeFilters)->filter()->isNotEmpty())
        <span class="font-bold">{{ $filteredRecords }}</span> del total de <span class="font-bold">{{ $totalRecords }}</span> registros en el sistema cumplen con el filtro.

        @else
            Se encontraron un total de <span class="font-bold">{{ $totalRecords }}</span> registros.
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
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->nivel_academico_nombre }} {{ $asistencia->anio_lectivo_anio }}">{{ $asistencia->nivel_academico_nombre }} {{ $asistencia->anio_lectivo_anio }}</td>
                                <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $asistencia->maestro_primer_nombre }} {{ $asistencia->maestro_primer_apellido }}">{{ $asistencia->maestro_primer_nombre }} {{ $asistencia->maestro_primer_apellido }}</td>
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
                                        <x-buttons.secondary wire:click.prevent="viewSession({{ $asistencia->id }})" title="Ver Detalles">
                                            <i class="ph ph-eye text-lg"></i>
                                        </x-buttons.secondary>
                                        <x-buttons.danger-secondary wire:click="confirmDeletion({{ $asistencia->id }})" title="Eliminar Asistencia">
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

    <!-- Loading overlay for viewing session -->
    <div wire:loading.delay.longer.flex wire:target="viewSession" class="absolute inset-0 items-center justify-center bg-white bg-opacity-75 z-40">
        <i class="ph ph-spinner-gap text-4xl text-sigedra-primary animate-spin"></i>
    </div>


    @if ($isReady)
        <div class="mt-8">
            {{ $asistencias->links('vendor.pagination.sigedra-pagination') }}
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-deletion" :show="$confirmingDeletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                ¿Estás seguro de que deseas eliminar este registro de asistencia?
            </h2>
            <p class="mt-1 text-base text-gray-600">
                Una vez eliminado, no se podrá recuperar.
            </p>
            <div class="mt-6 flex justify-end">
                <x-buttons.secondary x-on:click="$wire.set('confirmingDeletion', false)">
                    Cancelar
                </x-buttons.secondary>
                <x-danger-button class="ms-3" wire:click="delete">
                    Eliminar
                </x-danger-button>
            </div>
        </div>
    </x-modal>

    <!-- Session Details Overlay -->
    @if ($viewingSession)
    <div
        x-data="{ show: @entangle('viewingSession') }"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-x-full"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-full"
        class="absolute inset-0 bg-white z-50 overflow-y-auto"
    >
        <div class="px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="flex items-center gap-x-4 mb-8">
                <button wire:click="closeSessionView" class="text-sigedra-primary hover:text-sigedra-primary-dark transition-colors">
                    <i class="ph ph-arrow-left text-2xl"></i>
                </button>
                <div class="flex flex-col md:flex-row md:items-baseline md:gap-x-4">
                    <h1 class="text-2xl font-bold text-sigedra-primary">Detalle de la Sesión de Asistencia</h1>
                    <span class="text-base text-sigedra-text-medium">
                        {{ \Carbon\Carbon::parse($viewingSession->fecha)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </span>
                </div>
            </div>

            <!-- Session Info -->
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-details-field label="Curso" value="{{ $viewingSession->subject }}" />
                    <x-details-field label="Grado" value="{{ $viewingSession->nivel_academico_nombre }} {{ $viewingSession->anio_lectivo_anio }}" />
                    <x-details-field label="Maestro" value="{{ $viewingSession->maestro_nombre }}" />
                </div>

                <!-- Student Table -->
                <x-table class="-mx-4 md:mx-0">
                    <x-slot:head>
                        <tr>
                            <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">#</th>
                            <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Cédula</th>
                            <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]">Nombre completo</th>
                            <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">Estado</th>
                            <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[35%]">Observaciones</th>
                        </tr>
                    </x-slot:head>

                    <x-slot:body>
                        @forelse ($studentDetails as $student)
                        <tr class="bg-white hover:bg-gray-50">
                            <td class="px-6 py-3 text-base font-medium text-gray-800">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-base text-gray-800">{{ $student->cedula }}</td>
                            <td class="px-6 py-3 text-base text-gray-800 truncate" title="{{ $student->nombre_completo }}">{{ $student->nombre_completo }}</td>
                            <td class="px-6 py-3 text-base text-gray-800">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                                    @switch($student->estado)
                                        @case('Presente') bg-green-100 text-green-800 @break
                                        @case('Ausente') bg-red-100 text-red-800 @break
                                        @case('Tardía') bg-yellow-100 text-yellow-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch
                                ">
                                    {{ $student->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-base text-gray-800">{{ $student->observaciones ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-3 text-center text-sm text-sigedra-text-medium">No hay estudiantes registrados en esta sesión de asistencia.</td>
                        </tr>
                        @endforelse
                    </x-slot:body>
                </x-table>
            </div>
        </div>
    </div>
    @endif
</div>
