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
                    <div class="relative mt-1 max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input datepicker datepicker-buttons datepicker-autohide datepicker-format="yyyy-mm-dd" datepicker-autoselect-today wire:model.defer="startDate" id="start_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Seleccionar fecha" autocomplete="off">
                    </div>
                </div>
                <div>
                    <x-input-label for="end_date">Fecha de fin</x-input-label>
                     <div class="relative mt-1 max-w-sm">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>
                        <input datepicker datepicker-buttons datepicker-autohide datepicker-format="yyyy-mm-dd" datepicker-autoselect-today wire:model.defer="endDate" id="end_date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Seleccionar fecha" autocomplete="off">
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
