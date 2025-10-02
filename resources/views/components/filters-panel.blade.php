@props([
'allGrados',
'allMaterias',
'allMaestros',
'selectedMaestros',
])

<div x-data x-show="filtersOpen" class="mb-6" @filters-cleared.window="$el.querySelectorAll('input[type=checkbox]').forEach(c => c.checked = false); $el.querySelectorAll('input.flatpickr').forEach(i => i._flatpickr.clear());" x-cloak>
    <div class="bg-sigedra-light-bg p-4 rounded-lg border">
        <div class="grid grid-cols-1 md:grid-cols-2 {{ auth()->user()->hasRole('Maestro') ? 'lg:grid-cols-4' : 'lg:grid-cols-5' }} gap-4">
            <!-- Wrapper for date filters -->
            <div class="grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-2">
                <!-- Filtro por fecha -->
                <div>
                    <x-input-label for="start_date">Fecha de inicio</x-input-label>
                    <div class="relative max-w-sm mt-1">
                        <div class="absolute inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                            <i class="ph ph-calendar-blank w-4 h-4 text-sigedra-text-medium"></i>
                        </div>
                        <input id="start_date" type="text" class="custom-datepicker h-11 bg-white border border-sigedra-border text-sigedra-text-dark text-sm rounded-lg focus:border-sigedra-text-medium block w-full pe-10 p-2.5" placeholder="Seleccionar fecha" autocomplete="off" wire:model.defer="startDate">
                    </div>
                </div>
                <div>
                    <x-input-label for="end_date">Fecha de fin</x-input-label>
                    <div class="relative max-w-sm mt-1">
                        <div class="absolute inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                            <i class="ph ph-calendar-blank w-4 h-4 text-sigedra-text-medium"></i>
                        </div>
                        <input id="end_date" type="text" class="custom-datepicker h-11 bg-white border border-sigedra-border text-sigedra-text-dark text-sm rounded-lg focus:border-sigedra-text-medium block w-full pe-10 p-2.5" placeholder="Seleccionar fecha" autocomplete="off" wire:model.defer="endDate">
                    </div>
                </div>
            </div>

            <!-- Filtro por Grado -->
            <div x-data="{ open: false }" class="relative">
                <x-input-label for="grades">Grado</x-input-label>
                <x-filter-button @click="open = !open">
                    Seleccionar grados...
                </x-filter-button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white rounded-md border     " style="display: none;">
                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-sigedra-border ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        @foreach($allGrados as $anio => $grados)
                        <li x-data="{ expanded: true }" class="py-1">
                            <h3 @click="expanded = !expanded" class="flex items-center justify-between px-3 py-2 text-sm font-semibold text-sigedra-text-dark cursor-pointer hover:bg-sigedra-light-colored-bg">
                                <span>Año {{ $anio }}</span>
                                <i class="ph ph-caret-down text-lg transition-transform" :class="{'rotate-180': expanded}"></i>
                            </h3>
                            <ul x-show="expanded" class="pl-4 mt-1 space-y-1">
                                @foreach($grados as $grado)
                                <li>
                                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-sigedra-light-colored-bg rounded-md">
                                        <input wire:model.defer="selectedGrades" type="checkbox" value="{{ $grado->id }}" class="h-4 w-4 text-sigedra-text-medium border rounded focus:ring-sigedra-primary">
                                        <span class="ml-3 block font-normal truncate text-sigedra-text-dark">{{ $grado->nivelAcademico->nombre }}</span>
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
                <x-filter-button @click="open = !open">
                    Seleccionar materias...
                </x-filter-button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white rounded-md border     " style="display: none;">
                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-sigedra-border ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        @foreach($allMaterias as $materia)
                        <li>
                            <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-sigedra-light-colored-bg">
                                <input wire:model.defer="selectedMaterias" type="checkbox" value="{{ $materia->id }}" class="h-4 w-4 text-sigedra-primary      rounded focus:ring-sigedra-primary">
                                <span class="ml-3 block font-normal truncate">{{ $materia->nombre }}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if(!auth()->user()->hasRole('Maestro'))
            <!-- Filtro por Maestro -->
            <div x-data="{ open: false }" class="relative">
                <x-input-label for="maestro">Maestro</x-input-label>
                <x-filter-button @click="open = !open">
                    Seleccionar maestros...
                </x-filter-button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white rounded-md border     " style="display: none;">
                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-sigedra-border ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        @foreach($allMaestros as $maestro)
                        <li>
                            <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-sigedra-light-colored-bg">
                                <input wire:model.defer="selectedMaestros" type="checkbox" value="{{ $maestro->id }}" class="h-4 w-4 text-sigedra-primary      rounded focus:ring-sigedra-primary">
                                <span class="ml-3 block font-normal truncate">{{ $maestro->nombre_completo }}</span>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        <div class="flex justify-end gap-3 mt-4">
            <x-secondary-button wire:click="clearFilters">Limpiar Filtros</x-secondary-button>
            <x-primary-button wire:click="applyFilters">Aplicar Filtros</x-primary-button>
        </div>
    </div>
</div>
