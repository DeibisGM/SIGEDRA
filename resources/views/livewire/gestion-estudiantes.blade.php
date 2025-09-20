<div>
    {{-- Barra de filtros y búsqueda --}}
    <div class="space-y-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Filtro por Año Académico --}}
            <div>
                <label for="anio_academico_id" class="block font-semibold text-sm text-gray-800">Año Académico</label>
                <select wire:model.live="anio_academico_id" id="anio_academico_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">-- Todos los Años --</option>
                    @foreach($aniosAcademicos as $anio)
                    <option value="{{ $anio->id }}">{{ $anio->anio }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro por Grado (Dependiente del año) --}}
            <div>
                <label for="grado_id" class="block font-semibold text-sm text-gray-800">Grado</label>
                <select wire:model.live="grado_id" id="grado_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @disabled($grados->isEmpty())>
                    <option value="">-- Todos los Grados --</option>
                    @foreach($grados as $grado)
                    <option value="{{ $grado->id }}">{{ $grado->nivelAcademico->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Barra de Búsqueda --}}
        <div class="relative w-full">
            <label for="search" class="sr-only">Buscar</label>
            <input wire:model.live.debounce.300ms="search" id="search" type="text" class="py-2 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar por cédula, nombre, etc...">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
            </div>
        </div>
    </div>

    {{-- Indicador de Carga --}}
    <div wire:loading.flex class="items-center justify-center w-full p-4">
        <i class="ph ph-spinner ph-spin text-2xl text-sigedra-primary"></i>
        <span class="ms-2 text-sigedra-text-medium">Cargando...</span>
    </div>

    {{-- Contenedor de la tabla (solo se muestra cuando no está cargando) --}}
    <div wire:loading.remove>
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
                        No se encontraron estudiantes que coincidan con los filtros aplicados.
                    </td>
                </tr>
                @endforelse
            </x-slot:body>
        </x-table>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $estudiantes->links() }}
        </div>

        {{-- Modales de Confirmación de Eliminación --}}
        @foreach($estudiantes as $estudiante)
        <x-modal name="confirm-student-deletion-{{ $estudiante->id }}" focusable>
            <form wire:submit.prevent="deleteStudent({{ $estudiante->id }})" class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que deseas eliminar a {{ $estudiante->nombre_completo }}?
                </h2>
                <p class="mt-1 text-base text-gray-600">
                    Toda la información del estudiante será eliminada permanentemente. Esta acción no se puede deshacer.
                </p>
                <div class="mt-6 flex justify-end">
                    <x-buttons.secondary type="button" x-on:click="$dispatch('close')">
                        Cancelar
                    </x-buttons.secondary>
                    <x-buttons.danger class="ms-3" type="submit">
                        Eliminar Estudiante
                    </x-buttons.danger>
                </div>
            </form>
        </x-modal>
        @endforeach
    </div>
</div>
