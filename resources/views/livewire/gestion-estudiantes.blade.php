<div wire:init="loadEstudiantes">
    <x-table>
        <x-slot:head>
            <tr>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Cédula</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Nombre completo</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Edad</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Género</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Dirección</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Acciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @if ($isReady)
                @forelse ($estudiantes as $estudiante)
                <tr class="bg-white hover:bg-gray-50">
                    <td class="px-6 py-4 text-base font-medium text-gray-800">{{ $estudiante->cedula }}</td>
                    <td class="px-6 py-4 text-base text-gray-800">{{ $estudiante->nombre_completo }}</td>
                    <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $estudiante->edad }}</td>
                    <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $estudiante->genero }}</td>
                    <td class="px-6 py-4 text-base text-gray-800 truncate max-w-xs" title="{{ $estudiante->direccion }}">{{ $estudiante->direccion ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-base font-medium">
                        <div class="w-full flex items-center justify-center gap-x-2">
                            <x-buttons.secondary href="{{ route('estudiantes.show', $estudiante->id) }}" title="Ver Detalles del Estudiante">
                                <i class="ph ph-eye text-lg"></i>
                            </x-buttons.secondary>
                            <x-buttons.secondary href="#" title="Editar Estudiante">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </x-buttons.secondary>
                            <x-buttons.danger-secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-student-deletion-{{ $estudiante->id }}')" title="Eliminar Estudiante">
                                <i class="ph ph-trash text-lg"></i>
                            </x-buttons.danger-secondary>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-base text-gray-500">
                        No se encontraron estudiantes.
                    </td>
                </tr>
                @endforelse
            @else
                @for ($i = 0; $i < 5; $i++)
                <tr class="bg-white">
                    <td class="p-4" colspan="6">
                        <div class="animate-pulse h-8 bg-gray-200 rounded-md"></div>
                    </td>
                </tr>
                @endfor
            @endif
        </x-slot:body>
    </x-table>

    @if (is_a($estudiantes, 'Illuminate\Pagination\LengthAwarePaginator') && $estudiantes->hasPages())
        <div class="mt-4">
            {{ $estudiantes->links('vendor.pagination.tailwind') }}
        </div>
    @endif
</div>