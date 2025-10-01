<div wire:init="loadEstudiantes">
    <x-table>
        <x-slot:head>
            <tr>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%] bg-sigedra-medium-bg">Cédula</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[25%] bg-sigedra-medium-bg">Nombre completo</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%] bg-sigedra-medium-bg">Edad</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%] bg-sigedra-medium-bg">Género</th>
                <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%] bg-sigedra-medium-bg">Dirección</th>
                <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%] bg-sigedra-medium-bg">Acciones</th>
            </tr>
        </x-slot:head>

        <x-slot:body>
            @if ($isReady)
                @forelse ($estudiantes as $estudiante)
                    <tr wire:key="estudiante-{{ $estudiante->id }}" class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4 text-base font-medium text-gray-800">{{ $estudiante->cedula }}</td>
                        <td class="px-6 py-4 text-base text-gray-800">{{ $estudiante->nombre_completo }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $estudiante->edad }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $estudiante->genero }}</td>
                        <td class="px-6 py-4 text-base text-gray-800 truncate max-w-xs" title="{{ $estudiante->direccion }}">{{ $estudiante->direccion ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-base font-medium">
                            <div class="w-full flex items-center justify-center gap-x-2">
                                <x-secondary-button href="{{ route('estudiantes.show', $estudiante->id) }}" title="Ver Detalles del Estudiante"><i class="ph ph-eye text-lg"></i></x-secondary-button>
                                <x-secondary-button href="{{ route('estudiantes.edit', $estudiante) }}" title="Editar Estudiante"><i class="ph ph-pencil-simple text-lg"></i></x-secondary-button>
                                <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-student-deletion-{{ $estudiante->id }}')" title="Eliminar Estudiante"><i class="ph ph-trash text-lg"></i></x-danger-button>
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
                    <tr wire:key="skeleton-{{ $i }}" class="bg-white animate-pulse">
                        <td class="px-6 py-4 text-base font-medium text-gray-800">
                            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        </td>
                        <td class="px-6 py-4 text-base text-gray-800">
                            <div class="h-4 bg-gray-200 rounded w-full"></div>
                        </td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                        </td>
                        <td class="px-6 py-4 text-base text-gray-800 text-center">
                            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
                        </td>
                        <td class="px-6 py-4 text-base text-gray-800 truncate max-w-xs">
                            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                        </td>
                        <td class="px-6 py-4 text-base font-medium">
                            <div class="w-full flex items-center justify-center gap-x-2">
                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                            </div>
                        </td>
                    </tr>
                @endfor
            @endif
        </x-slot:body>
    </x-table>

    @if ($isReady && $estudiantes->hasPages())
        <div class="mt-8">
            {{ $estudiantes->links('vendor.pagination.sigedra-pagination') }}
        </div>
    @endif

    @if ($isReady)
        @foreach ($estudiantes as $estudiante)
            <!-- Modal de confirmación para cada estudiante -->
            <x-modal name="confirm-student-deletion-{{ $estudiante->id }}" :show="false" maxWidth="md">
                <form method="POST" action="{{ route('estudiantes.destroy', $estudiante) }}" class="p-6">
                    @csrf
                    @method('DELETE')

                    <h2 class="text-lg font-medium text-gray-900">
                        ¿Estás seguro de que deseas desactivar este estudiante?
                    </h2>

                    <p class="mt-3 text-sm text-gray-600">
                        Estás a punto de desactivar a <strong>{{ $estudiante->nombre_completo }}</strong> (Cédula: {{ $estudiante->cedula }}).
                        Esta acción marcará al estudiante como inactivo en el sistema.
                    </p>

                    <div class="mt-6 flex justify-end gap-3">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">
                            Cancelar
                        </x-secondary-button>

                        <x-danger-button type="submit">
                            Desactivar Estudiante
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    @endif

</div>
