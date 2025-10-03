<div wire:init="loadAsistencias" x-data="{ filtersOpen: false, isDeleting: false }" @deleting.window="isDeleting = true" @deletion-finished.window="isDeleting = false" class="relative py-5">

    <!-- Indicador de Borrado -->
    <div x-show="isDeleting" style="display: none;" class="mb-4 bg-red-100 border border-red-400 text-red-700 rounded flex items-center gap-2 px-4 py-3" role="alert">
        <div class="w-4 h-4 border-2 border-t-red-500 border-red-300 rounded-full animate-spin"></div>
        <span class="text-base">Borrando...</span>
    </div>

    <!-- Mensajes de Éxito/Error -->
    @if (session()->has('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    @if (session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Botón de Filtros -->
    <div class="flex justify-end items-center mb-4">
        <x-secondary-button @click="filtersOpen = !filtersOpen" class="w-full md:w-auto justify-center text-sm" title="Filtros">
            <i class="ph ph-faders text-lg"></i>
            <span class="sm:inline">Filtros</span>
            <i class="ph ph-caret-down text-lg transition-transform" :class="{'rotate-180': filtersOpen}"></i>
        </x-secondary-button>
    </div>

    <!-- Componentes de Filtros -->
    <x-filters-panel :allGrados="$allGrados" :allMaterias="$allMaterias" :allMaestros="$allMaestros" :selectedMaestros="$selectedMaestros" />
    <x-active-filters-summary :activeFilters="$activeFilters" :allMaestros="$allMaestros" />

    <!-- Skeleton para Filtrado (CORREGIDO) -->
    <div wire:loading wire:target="applyFilters, clearFilters, nextPage, prevPage, gotoPage" class="w-full">
        <x-skeletons.attendance-table />
    </div>

    <!-- Contenido Principal -->
    {{-- Se oculta mientras se aplican filtros para mostrar el skeleton --}}
    <div wire:loading.remove wire:target="applyFilters, clearFilters, nextPage, prevPage, gotoPage">
        @if ($isReady)
        <!-- Tabla para Escritorio -->
        <div class="relative overflow-x-auto hidden md:block">
            <x-table class="table-fixed w-full">
                <x-slot:head>
                    <tr>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider whitespace-nowrap" style="width: 12%;">Fecha</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 20%;">Materia</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 18%;">Grado</th>
                        <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 25%;">Maestro</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 5%;">P</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 5%;">T</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 5%;">A</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider" style="width: 5%;">J</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider whitespace-nowrap" style="width: 10%;">Acciones</th>
                    </tr>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($asistencias as $asistencia)
                    <tr wire:key="asistencia-{{ $asistencia->id }}"
                        class="hover:bg-sigedra-medium-bg transition-colors duration-500"
                        x-data="{ highlighted: {{ $asistencia->id === $newAttendanceId ? 'true' : 'false' }} }"
                        x-init="if (highlighted) { setTimeout(() => highlighted = false, 5000) }"
                        :class="highlighted ? 'bg-sigedra-light-colored-bg' : ''">

                        <td class="px-6 py-3 text-base font-medium text-sigedra-text-dark whitespace-nowrap overflow-hidden">{{ $asistencia->fecha->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark overflow-hidden whitespace-nowrap" title="{{ $asistencia->cargaAcademica->materia->nombre }}">{{ $asistencia->cargaAcademica->materia->nombre }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark overflow-hidden whitespace-nowrap" title="{{ $asistencia->cargaAcademica->grado->nivelAcademico->nombre }}">{{ $asistencia->cargaAcademica->grado->nivelAcademico->nombre }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark overflow-hidden whitespace-nowrap" title="{{ $asistencia->cargaAcademica->maestro->nombre_completo }}">{{ $asistencia->cargaAcademica->maestro->nombre_completo }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark text-center overflow-hidden">{{ $asistencia->presentes_count }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark text-center overflow-hidden">{{ $asistencia->tardias_count }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark text-center overflow-hidden">{{ $asistencia->ausentes_count }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark text-center overflow-hidden">{{ $asistencia->justificadas_count }}</td>
                        <td class="px-6 py-3 text-center overflow-hidden">
                            <div class="flex items-center justify-center gap-x-2">
                                <x-secondary-button @click.prevent="$wire.dispatch('load-session', { sessionId: {{ $asistencia->id }} }); $dispatch('view-session', { sessionId: {{ $asistencia->id }} })" title="Ver Detalles"><i class="ph ph-eye text-lg"></i></x-secondary-button>
                                <x-danger-button x-on:click.prevent="$wire.set('recordIdToDelete', {{ $asistencia->id }}); $dispatch('open-modal', 'confirm-deletion')" title="Eliminar Asistencia"><i class="ph ph-trash text-lg"></i></x-danger-button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <x-empty-state message="No se encontraron registros de asistencia que coincidan con los filtros aplicados." />
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>

        <!-- Tarjetas para Móvil -->
        <div class="block md:hidden space-y-2">
            @forelse ($asistencias as $asistencia)
            <div wire:key="asistencia-card-{{ $asistencia->id }}" class="bg-sigedra-light-bg border rounded-lg p-4 transition-all hover:shadow-md">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">{{ $asistencia->cargaAcademica->materia->nombre }}</p>
                        <p class="text-sm text-sigedra-text-medium">{{ $asistencia->fecha->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="mt-4 space-y-1">
                    <p class="text-sm"><span class="font-semibold">Grado:</span> {{ $asistencia->cargaAcademica->grado->nivelAcademico->nombre }} ({{ $asistencia->cargaAcademica->grado->anioAcademico->anio }})</p>
                    <p class="text-sm"><span class="font-semibold">Maestro:</span> {{ $asistencia->cargaAcademica->maestro->nombre_completo }}</p>
                </div>
                <div class="mt-4 border-t pt-4 flex justify-between items-center">
                    <div class="flex space-x-4 text-center">
                        <div><p class="font-bold">{{ $asistencia->presentes_count }}</p><p class="text-xs font-medium text-sigedra-text-medium">P</p></div>
                        <div><p class="font-bold">{{ $asistencia->tardias_count }}</p><p class="text-xs font-medium text-sigedra-text-medium">T</p></div>
                        <div><p class="font-bold">{{ $asistencia->ausentes_count }}</p><p class="text-xs font-medium text-sigedra-text-medium">A</p></div>
                        <div><p class="font-bold">{{ $asistencia->justificadas_count }}</p><p class="text-xs font-medium text-sigedra-text-medium">J</p></div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <x-secondary-button @click.prevent="$wire.dispatch('load-session', { sessionId: {{ $asistencia->id }} }); $dispatch('view-session', { sessionId: {{ $asistencia->id }} })" title="Ver Detalles"><i class="ph ph-eye text-lg"></i></x-secondary-button>
                        <x-danger-button wire:click="confirmDeletion({{ $asistencia->id }})" title="Eliminar Asistencia"><i class="ph ph-trash text-lg"></i></x-danger-button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10"><p>No se encontraron registros.</p></div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $asistencias->links('vendor.pagination.sigedra-pagination') }}
        </div>
        @else
        <!-- Skeleton Inicial (CORREGIDO) -->
        {{-- Se muestra solo en la carga inicial de la página, antes de que los datos estén listos. --}}
        <x-skeletons.attendance-table />
        @endif
    </div>

    <!-- Modal de Confirmación de Borrado -->
    <x-confirm-deletion-modal
        title="¿Estás seguro de que deseas eliminar este registro de asistencia?"
        text="Una vez eliminado, no se podrá recuperar."
        wire:click="delete"
    />

    <!-- Footer Flotante para Móviles -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 z-10">
        <x-primary-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'pre-create-modal')"
            class="w-full justify-center py-3"
        >
            <i class="ph ph-plus text-base"></i>
            <span>Crear Asistencia</span>
        </x-primary-button>
    </div>
</div>
