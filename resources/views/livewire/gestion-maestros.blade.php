<div>
    <!-- Desktop Table -->
    <div class="hidden md:block">
        <x-table>
            <x-slot:head>
                <tr>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Nombre</th>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Email</th>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Cédula</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Acciones</th>
                </tr>
            </x-slot:head>
            <x-slot:body>
                @forelse ($maestros as $maestro)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->primer_nombre }} {{ $maestro->primer_apellido }}</td>
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->correo }}</td>
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->user->cedula ?? 'N/A' }}</td>
                        <td class="px-6 py-3 text-base font-medium">
                            <div class="w-full flex items-center justify-center">
                               <x-secondary-button as="a" href="{{ route('maestros.show', $maestro->id) }}" title="Ver informacion">
                                    <i class="ph ph-eye text-lg"></i>
                               </x-secondary-button>
                                <x-secondary-button as="a" href="{{ route('maestros.edit', $maestro->id) }}" title="Editar Maestro"><i class="ph ph-pencil-simple text-lg"></i></x-secondary-button>
                                <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-student-deletion-{{ $maestro->id }}')" title="Eliminar Maestro"><i class="ph ph-trash text-lg"></i></x-danger-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No hay maestros registrados.</td>
                    </tr>
                @endforelse
            </x-slot:body>
        </x-table>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden space-y-4">
        @forelse ($maestros as $maestro)
            <div class="bg-white border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">{{ $maestro->primer_nombre }} {{ $maestro->primer_apellido }}</p>
                        <p class="text-sm text-gray-600">{{ $maestro->user->cedula ?? 'N/A' }}</p>
                    </div>
                    <x-secondary-button as="a" href="#">
                        <i class="ph ph-eye text-lg"></i>
                    </x-secondary-button>
                </div>
                <div class="mt-4">
                    <p class="text-sm"><span class="font-semibold">Email:</span> {{ $maestro->correo }}</p>
                </div>
            </div>
        @empty
            <div class="text-center py-10">
                <p>No hay maestros registrados.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $maestros->links('vendor.pagination.sigedra-pagination') }}
    </div>
</div>
