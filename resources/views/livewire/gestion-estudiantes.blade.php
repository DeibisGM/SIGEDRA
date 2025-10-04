<div wire:init="loadEstudiantes">
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
                                    <x-secondary-button as="a" href="{{ route('estudiantes.show', $estudiante->id) }}" title="Ver Detalles del Estudiante"><i class="ph ph-eye text-lg"></i></x-secondary-button>
                                    <x-secondary-button as="a" href="{{ route('estudiantes.edit', $estudiante) }}" title="Editar Estudiante"><i class="ph ph-pencil-simple text-lg"></i></x-secondary-button>
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
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden space-y-4">
        @if ($isReady)
            @forelse ($estudiantes as $estudiante)
                <div x-data="{ openMenu: false }" wire:key="estudiante-mobile-{{ $estudiante->id }}" class="bg-white border rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-lg">{{ $estudiante->nombre_completo }}</p>
                            <p class="text-sm text-gray-600"><span>Cédula: </span>{{ $estudiante->cedula }}</p>
                            <p class="text-sm text-gray-600"><span>Edad: </span>{{ $estudiante->edad }}</p>
                            <p class="text-sm text-gray-600"><span>Género: </span>{{ $estudiante->genero }}</p>
                        </div>

                        {{-- menú de acciones --}}
                        <div class="relative">
                            {{-- Botón para abrir/cerrar --}}
                            <button type="button" @click="openMenu = !openMenu" title="Opciones" class="p-1 -mt-1 -mr-1">
                                <i class="ph ph-dots-three-vertical text-xl text-gray-600 hover:text-gray-900"></i>
                            </button>

                            <div x-show="openMenu"
                                 @click.outside="openMenu = false"
                                 x-transition
                                 class="absolute z-10 top-full right-0 mt-0 bg-white border border-gray-100 rounded-md shadow-lg">
                                <div class="flex flex-col">
                                    <div>
                                        <x-secondary-button as="a" href="{{ route('estudiantes.show', $estudiante->id) }}"
                                                            class="me-2 !bg-transparent !border-none !shadow-none !text-gray-700 hover:!text-gray-900 !w-full !justify-start">
                                            <i class="ph ph-eye text-lg"></i>
                                            <span>Ver</span>
                                        </x-secondary-button>
                                    </div>

                                    <div class="border-t border-gray-100">
                                        <x-secondary-button as="a" href="{{ route('estudiantes.edit', $estudiante) }}"
                                                            class="me-2 !bg-transparent !border-none !shadow-none !text-gray-700 hover:!text-gray-900 !w-full !justify-start">
                                            <i class="ph ph-pencil-simple text-lg"></i>
                                            <span>Editar</span>
                                        </x-secondary-button>
                                    </div>

                                    <div class="border-t border-gray-100">
                                        <x-danger-button
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-student-deletion-mobile-{{ $estudiante->id }}'); openMenu = false"
                                            class="me-2 !bg-transparent !border-none !shadow-none !text-red-600 hover:!text-red-800 !w-full !justify-start">
                                            <i class="ph ph-trash text-lg"></i>
                                            <span>Desactivar</span>
                                        </x-danger-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-sm"><span class="font-semibold">Dirección:</span> {{ $estudiante->direccion ?? 'N/A' }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p>No se encontraron estudiantes.</p>
                </div>
            @endforelse
        @else
            {{-- Skeleton para mobile --}}
            @for ($i = 0; $i < 3; $i++)
                <div wire:key="skeleton-mobile-{{ $i }}" class="bg-white border rounded-lg p-4 animate-pulse">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="h-5 bg-gray-200 rounded w-3/4 mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/2 mb-1"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/3 mb-1"></div>
                            <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                        </div>
                        <div class="h-6 w-6 bg-gray-200 rounded"></div>
                    </div>
                    <div class="mt-4">
                        <div class="h-4 bg-gray-200 rounded w-full"></div>
                    </div>
                </div>
            @endfor
        @endif
    </div>

    @if ($isReady && $estudiantes->hasPages())
        <div class="mt-8">
            {{ $estudiantes->links('vendor.pagination.sigedra-pagination') }}
        </div>
    @endif

    @if ($isReady)
        @foreach ($estudiantes as $estudiante)
            <!-- Modal de confirmación para escritorio -->
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

            <!-- Modal de confirmación para móvil -->
            <x-modal name="confirm-student-deletion-mobile-{{ $estudiante->id }}" :show="false" maxWidth="md">
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
