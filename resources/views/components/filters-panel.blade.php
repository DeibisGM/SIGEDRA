@props([
    'allGrados',
    'allMaterias',
    'allMaestros',
    'selectedMaestros',
])

<div x-data x-show="filtersOpen" class="mb-6" @filters-cleared.window="$el.querySelectorAll('input[type=checkbox]').forEach(c => c.checked = false); $el.querySelectorAll('input.flatpickr').forEach(i => i._flatpickr.clear());">
    <div class="bg-white p-4 rounded-lg border border-sigedra-border">
        <div class="grid grid-cols-1 md:grid-cols-2 {{ auth()->user()->hasRole('Maestro') ? 'lg:grid-cols-4' : 'lg:grid-cols-5' }} gap-4">
            <!-- Wrapper for date filters -->
            <div class="grid grid-cols-2 gap-4 md:col-span-2 lg:col-span-2">
                <!-- Filtro por fecha -->
                <div>
                    <x-input-label for="start_date">Fecha de inicio</x-input-label>
                    <div class="relative mt-1">
                        <x-text-input wire:model.defer="startDate" id="start_date" class="block w-full truncate flatpickr pl-3 pr-10 py-2 border-sigedra-border shadow-sm sm:text-sm" type="text" name="start_date" placeholder="Seleccionar fecha" autocomplete="off" />
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
                        <x-text-input wire:model.defer="endDate" id="end_date" class="block w-full truncate flatpickr pl-3 pr-10 py-2 border-sigedra-border shadow-sm sm:text-sm" type="text" name="end_date" placeholder="Seleccionar fecha" autocomplete="off" />
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

            @if(!auth()->user()->hasRole('Maestro'))
            <!-- Filtro por Maestro -->
            <div x-data="{ open: false }" class="relative">
                <x-input-label for="maestro">Maestro</x-input-label>
                <button @click="open = !open" type="button" class="relative mt-1 w-full text-left bg-white border border-sigedra-border rounded-md shadow-sm pl-3 pr-10 py-2 focus:outline-none focus:ring-1 focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm flex items-center">
                    <span class="block truncate flex-grow">Seleccionar maestros...</span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                        <i class="ph ph-caret-down text-lg text-gray-400"></i>
                    </span>
                </button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md border border-sigedra-border" style="display: none;">
                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        @foreach($allMaestros as $maestro)
                            <li>
                                <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                                    <input wire:model.defer="selectedMaestros" type="checkbox" value="{{ $maestro->id }}" class="h-4 w-4 text-sigedra-primary border-gray-300 rounded focus:ring-sigedra-primary">
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
            <x-buttons.secondary wire:click="clearFilters">Limpiar Filtros</x-buttons.secondary>
            <x-buttons.primary wire:click="applyFilters">Aplicar Filtros</x-buttons.primary>
        </div>
    </div>
</div>
