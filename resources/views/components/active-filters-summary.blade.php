@props([
    'activeFilters',
    'allMaestros',
])

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
