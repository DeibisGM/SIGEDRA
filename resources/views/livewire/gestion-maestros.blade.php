<div>
    @if (session('success'))
    <x-flash-message type="success" :message="session('success')" />
    @endif

    @if (session('error'))
    <x-flash-message type="error" :message="session('error')" />
    @endif

    <!-- Desktop Table -->
    <div class="hidden md:block">
        <x-table>
            <x-slot:head>
                <tr>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Cédula</th>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Nombre</th>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Teléfono</th>
                    <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Email</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider bg-sigedra-medium-bg">Acciones</th>
                </tr>
            </x-slot:head>
            <x-slot:body>
                @forelse ($maestros as $maestro)
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->user->cedula ?? '-' }}</td>
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->primer_nombre }} {{ $maestro->primer_apellido }} {{ $maestro->segundo_apellido }}</td>
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->telefono ?? '-' }}</td>
                        <td class="px-6 py-3 text-base text-gray-800">{{ $maestro->user->email ?? '-' }}</td>
                        <td class="px-6 py-3 text-base font-medium">
                            <div class="w-full flex items-center justify-center gap-2">
                               <x-secondary-button as="a" href="{{ route('maestros.show', $maestro->id) }}" title="Ver informacion">
                                    <i class="ph ph-eye text-lg"></i>
                               </x-secondary-button>
                                <x-secondary-button as="a" href="{{ route('maestros.edit', $maestro->id) }}" title="Editar Maestro"><i class="ph ph-pencil-simple text-lg"></i></x-secondary-button>

                                <x-danger-button
                                    title="Eliminar Maestro"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-maestro-destroy');
                                    $dispatch('set-maestro-action', { url: '{{ route('maestros.destroy', $maestro->id) }}' });">
                                    <i class="ph ph-trash text-lg"></i>
                                </x-danger-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No hay maestros registrados.</td>
                    </tr>
                @endforelse

                <x-pre-delete-modal
                    name="confirm-maestro-destroy"
                    {{-- Ruta base con :id --}}
                    route="{{ route('maestros.destroy', ['maestro' => ':id']) }}"
                    id=""
                    title="Eliminar acceso al maestro"
                    text="¿Esta seguro de eliminar el acceso a este maestro?"
                />

            </x-slot:body>
        </x-table>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden space-y-4">
        @forelse ($maestros as $maestro)
        <div x-data="{ openMenu: false }" class="bg-white border rounded-lg p-4">

            <div class="flex justify-between items-start">
                <div>

                    <p class="font-bold text-lg">{{ $maestro->primer_nombre }} {{ $maestro->primer_apellido }} {{ $maestro->segundo_apellido }}</p>
                    <p class="text-sm text-gray-600"><span>Cédula: </span>{{ $maestro->user->cedula ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600"><span>Teléfono: </span>{{ $maestro->telefono ?? 'N/A' }}</p>
                </div>

                {{-- menu de acciones --}}
                <div class="relative">

                    {{-- Botón para abrir/cerrar --}}
                    <button type="button" @click="openMenu = !openMenu" title="Opciones" class="p-1 -mt-1 -mr-1">
                        <i class="ph ph-dots-three-vertical text-xl text-gray-600 hover:text-gray-900"></i>
                    </button>

                    <div x-show="openMenu"
                         @click.outside="openMenu = false"
                         x-transition
                    <div class="absolute z-0 top-full right-0 mt-0 bg-white border border-gray-100 rounded-md shadow-lg">


                    <div class="flex flex-col">
                            <div>
                                <x-secondary-button as="a" href="{{ route('maestros.show', $maestro->id) }}"
                                                    class=" me-2 !bg-transparent !border-none !shadow-none !text-gray-700 hover:!text-gray-900 !w-full !justify-start">
                                    <i class="ph ph-eye text-lg"></i>
                                    <span>Ver</span>
                                </x-secondary-button>
                            </div>

                            <div class="border-t border-gray-100">
                                <x-secondary-button as="a" href="{{ route('maestros.edit', $maestro->id) }}"
                                                    class=" me-2 !bg-transparent !border-none !shadow-none !text-gray-700 hover:!text-gray-900 !w-full !justify-start">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                    <span>Editar</span>
                                </x-secondary-button>
                            </div>

                            <div class="border-t border-gray-100">
                                <x-danger-button
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-maestro-destroy-cel');
                                    $dispatch('set-maestro-action', { url: '{{ route('maestros.destroy', $maestro->id) }}' });"
                                    class=" me-2 !bg-transparent !border-none !shadow-none !text-red-600 hover:!text-red-800 !w-full !justify-start">
                                    <i class="ph ph-trash text-lg"></i>
                                    <span>Eliminar</span>
                                </x-danger-button>
                            </div>
                        </div>
                    </div>







                </div>

            </div>

            <div class="mt-4">
                <p class="text-sm"><span class="font-semibold">Email:</span> {{ $maestro->user->email ?? 'N/A' }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-10">
            <p>No hay maestros registrados.</p>
        </div>
        @endforelse

        <x-pre-delete-modal
            name="confirm-maestro-destroy-cel"
            {{-- Ruta base con :id --}}
            route="{{ route('maestros.destroy', ['maestro' => ':id']) }}"
            id=""
            title="Eliminar acceso al maestro"
            text="¿Esta seguro de eliminar el acceso a este maestro?"
        />

    </div>

    <div class="mt-8">
        {{ $maestros->links('vendor.pagination.sigedra-pagination') }}
    </div>
</div>
