<!-- resources/views/livewire/attendance/attendance-history.blade.php -->

<div wire:init="loadAsistencias" x-data="{ filtersOpen: false }" class="relative py-5">
    <!-- Filtros -->
    <div class="flex justify-end items-center mb-4">
        <x-secondary-button @click="filtersOpen = !filtersOpen" class="w-full md:w-auto justify-center text-sm" title="Filtros">
            <i class="ph ph-faders text-lg"></i>
            <span class="sm:inline">Filtros</span>
            <i class="ph ph-caret-down text-lg transition-transform" :class="{'rotate-180': filtersOpen}"></i>
        </x-secondary-button>
    </div>

    <x-filters-panel :allGrados="$allGrados" :allMaterias="$allMaterias" :allMaestros="$allMaestros" :selectedMaestros="$selectedMaestros" />
    <x-active-filters-summary :activeFilters="$activeFilters" :allMaestros="$allMaestros" />

    <!-- Tabla Desktop -->
    <div class="relative overflow-x-auto hidden md:block">
        @if ($isReady)
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
                <tr wire:key="asistencia-{{ $asistencia->id }}" class="hover:bg-sigedra-medium-bg transition-colors">
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
                            <x-danger-button wire:click="confirmDeletion({{ $asistencia->id }})" title="Eliminar Asistencia"><i class="ph ph-trash text-lg"></i></x-danger-button>
                        </div>
                    </td>
                </tr>
                @empty
                <x-empty-state message="No se encontraron registros de asistencia que coincidan con los filtros aplicados." />
                @endforelse
            </x-slot:body>
        </x-table>
        @else
        <!-- Skeleton con altura calculada de forma precisa -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <!-- Header Skeleton -->
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <div class="flex items-center gap-x-4">
                    <div class="h-6 bg-gray-300 rounded animate-pulse w-[250px]"></div>

                </div>
            </div>

            <!-- Content Skeleton -->
            <div class="divide-y divide-gray-200">
                @for ($i = 0; $i < 5; $i++)
                <div class="px-6 py-3 animate-pulse">
                    <div class="flex items-center gap-x-4">
                        <div class="h-[38px] bg-gray-200 rounded flex-1"></div>
                        <div class="h-[38px] bg-gray-200 rounded flex-1"></div>
                        <div class="h-[38px] bg-gray-200 rounded flex-1"></div>

                        <div class="flex items-center justify-center gap-x-2" style="width: 10%;">
                            <div class="h-[38px] w-[38px] bg-gray-200 rounded"></div>
                            <div class="h-[38px] w-[38px] bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        @endif

    </div>

    <!-- Cards Mobile -->
    <div class="block md:hidden space-y-2">
        @if ($isReady)
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
        @else
        <!-- Skeleton Mobile -->
        @for ($i = 0; $i < 5; $i++)
        <div class="bg-white border rounded-lg p-4 animate-pulse">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <div class="h-5 w-32 bg-gray-200 rounded"></div>
                    <div class="h-4 w-24 bg-gray-200 rounded"></div>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <div class="h-4 w-48 bg-gray-200 rounded"></div>
                <div class="h-4 w-40 bg-gray-200 rounded"></div>
            </div>
            <div class="mt-4 border-t pt-4 flex justify-between items-center">
                <div class="flex space-x-4">
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                </div>
                <div class="flex space-x-2">
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>
        @endfor
        @endif
    </div>

    <!-- Paginación -->
    @if ($isReady)
    <div class="mt-8">
        {{ $asistencias->links('vendor.pagination.sigedra-pagination') }}
    </div>
    @endif

    <!-- Modal de Confirmación -->
    <x-modal name="confirm-deletion" :show="$confirmingDeletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-sigedra-text-dark">¿Estás seguro de que deseas eliminar este registro de asistencia?</h2>
            <p class="mt-1 text-base text-sigedra-text-medium">Una vez eliminado, no se podrá recuperar.</p>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$wire.set('confirmingDeletion', false)">Cancelar</x-secondary-button>
                <x-danger-button class="ms-3" wire:click="delete">Eliminar</x-danger-button>
            </div>
        </div>
    </x-modal>

    <!-- INICIO: Footer para Móviles -->
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
    <!-- FIN: Footer para Móviles -->

</div>
