<div wire:init="loadAsistencias">
    <!-- Barra de Búsqueda y Filtros -->
    <div class="flex flex-col md:flex-row gap-3 justify-between items-center mb-6">
        <div class="relative w-full md:w-auto md:flex-1">
            <input wire:model.debounce.500ms="search" type="text" class="py-2 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar por fecha o curso...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
        <div class="flex gap-3 w-full md:w-auto justify-end">
            <x-buttons.secondary class="w-full md:w-auto justify-center text-sm" title="Filtros">
                <i class="ph ph-faders text-lg"></i>
                <span class="sm:inline">Filtros</span>
            </x-buttons.secondary>
        </div>
    </div>

    <x-table>
        <x-slot:head>
            <tr>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Fecha</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Curso</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Grado</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Presentes</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Tardías</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Ausentes</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Asistencia %</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Acciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @if ($isReady)
                @forelse ($asistencias as $asistencia)
                    <tr wire:key="asistencia-{{ $asistencia->id }}" class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 text-base font-medium text-gray-800">{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-base text-gray-800">{{ $asistencia->curso }}</td>
                        <td class="px-6 py-4 text-base text-gray-800">{{ $asistencia->grado }}</td>
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
                            No se encontraron registros de asistencia.
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
