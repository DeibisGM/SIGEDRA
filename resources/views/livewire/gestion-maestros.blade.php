<div wire:init="loadMaestros" x-data="{}" x-on:remount.window="$wire.set('isReady', false); setTimeout(() => $wire.loadMaestros(), 50)">
    @if (session('success'))
        <x-flash-message type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-flash-message type="error" :message="session('error')" />
    @endif

    <div x-data="{ filtersOpen: false }">
        <div class="flex justify-end items-center mb-4">
            <x-secondary-button @click="filtersOpen = !filtersOpen" class="w-full md:w-auto justify-center text-sm" title="Filtros">
                <i class="ph ph-faders text-lg"></i>
                <span class="sm:inline">Filtros</span>
                <i class="ph ph-caret-down text-lg transition-transform" :class="{'rotate-180': filtersOpen}"></i>
            </x-secondary-button>
        </div>

        <div x-show="filtersOpen" x-collapse.duration.300ms style="display: none;" class="bg-gray-50 p-4 mb-6 rounded-lg border border-gray-200 shadow-inner">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Opciones de Filtro</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block font-medium text-sm text-gray-700 mb-1">Buscar por Cédula o Nombre</label>
                    <input
                        type="text"
                        id="search"
                        wire:model="search"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                        placeholder="Escriba cédula o nombre..."
                    />
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">Estado del Maestro</label>
                    <div class="flex items-center gap-2">
                        <button
                            wire:click="filterByStatus('active')"
                            @class([
                                'px-4 py-2 text-sm font-semibold rounded-full transition-colors',
                                'bg-sigedra-primary text-white' => $activeFilter === 'active',
                                'bg-gray-200 text-gray-700 hover:bg-gray-300' => $activeFilter !== 'active',
                            ])
                        >
                            Activos
                        </button>
                        <button
                            wire:click="filterByStatus('inactive')"
                            @class([
                                'px-4 py-2 text-sm font-semibold rounded-full transition-colors',
                                'bg-sigedra-primary text-white' => $activeFilter === 'inactive',
                                'bg-gray-200 text-gray-700 hover:bg-gray-300' => $activeFilter !== 'inactive',
                            ])
                        >
                            Inactivos
                        </button>
                        <button
                            wire:click="filterByStatus('all')"
                            @class([
                                'px-4 py-2 text-sm font-semibold rounded-full transition-colors',
                                'bg-sigedra-primary text-white' => $activeFilter === 'all',
                                'bg-gray-200 text-gray-700 hover:bg-gray-300' => $activeFilter !== 'all',
                            ])
                        >
                            Todos
                        </button>
                    </div>
                </div>
                <div class="flex items-end justify-end gap-2">
                    <x-primary-button wire:click="applyFilters" class="py-2.5">Buscar</x-primary-button>
                    <x-secondary-button wire:click="clearFilters" class="py-2.5">Limpiar</x-secondary-button>
                </div>
            </div>
        </div>

        <div wire:loading wire:target="filterByStatus, applyFilters, clearFilters, nextPage, prevPage, gotoPage" class="w-full">
            <x-skeletons.maestros-table-skeleton />
        </div>

        <div wire:loading.remove wire:target="filterByStatus, applyFilters, clearFilters, nextPage, prevPage, gotoPage">
            @if ($isReady)
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
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-maestro-destroy'); $dispatch('set-maestro-action', { url: '{{ route('maestros.destroy', $maestro->id) }}' });">
                                            <i class="ph ph-trash text-lg"></i>
                                        </x-danger-button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">No hay maestros que coincidan con la búsqueda.</td>
                            </tr>
                            @endforelse
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
                            <div class="relative">
                                <button type="button" @click="openMenu = !openMenu" title="Opciones" class="p-1 -mt-1 -mr-1">
                                    <i class="ph ph-dots-three-vertical text-xl text-gray-600 hover:text-gray-900"></i>
                                </button>
                                <div x-show="openMenu" @click.outside="openMenu = false" x-transition class="absolute z-10 top-full right-0 mt-0 bg-white border border-gray-100 rounded-md shadow-lg">
                                    <div class="flex flex-col">

                                        <x-secondary-button as="a" href="{{ route('maestros.show', $maestro->id) }}" class="me-2 !bg-transparent !border-none !shadow-none !text-gray-700 hover:!text-gray-900 !w-full !justify-start">
                                            <i class="ph ph-eye text-lg"></i>
                                            <span>Ver</span>
                                        </x-secondary-button>

                                        <div class="border-t border-gray-100"></div>
                                        <x-secondary-button as="a" href="{{ route('maestros.edit', $maestro->id) }}" class="me-2 !bg-transparent !border-none !shadow-none !text-gray-700 hover:!text-gray-900 !w-full !justify-start">
                                            <i class="ph ph-pencil-simple text-lg"></i>
                                            <span>Editar</span>
                                        </x-secondary-button>
                                        <div class="border-t border-gray-100"></div>
                                        <x-danger-button
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-maestro-destroy'); $dispatch('set-maestro-action', { url: '{{ route('maestros.destroy', $maestro->id) }}' });"
                                            class="me-2 !bg-transparent !border-none !shadow-none !text-red-600 hover:!text-red-800 !w-full !justify-start">
                                            <i class="ph ph-trash text-lg"></i>
                                            <span>Eliminar</span>
                                        </x-danger-button>
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
                        <p>No hay maestros que coincidan con la búsqueda.</p>
                    </div>
                    @endforelse
                </div>
            @else
                <x-skeletons.maestros-table-skeleton />
            @endif
        </div>

        <div class="mt-8">
            {{ $maestros->links('vendor.pagination.sigedra-pagination') }}
        </div>
    </div>

    <x-pre-delete-modal
        name="confirm-maestro-destroy"
        route="{{ route('maestros.destroy', ['maestro' => ':id']) }}"
        id=""
        title="Eliminar acceso al maestro"
        text="¿Esta seguro de eliminar el acceso a este maestro?"
    />
</div>
