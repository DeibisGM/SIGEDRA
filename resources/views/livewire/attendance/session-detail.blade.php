<!-- resources/views/livewire/attendance/session-detail.blade.php -->

<div class="relative min-h-[400px] pb-24 md:pb-0">
    @if ($session)
    <header class="">
        <div class="container mx-auto px-0 py-5 flex items-center justify-between">
            <div class="flex items-baseline gap-x-2">
                <button wire:click="closeSession" title="Volver al historial" class="inline-flex items-center justify-center rounded-full text-sigedra-text-medium hover:text-sigedra-primary-dark focus:outline-none transition-colors w-10 h-10">
                    <span wire:loading.remove wire:target="closeSession">
                        <i class="ph ph-arrow-left text-xl"></i>
                    </span>
                    <span wire:loading wire:target="closeSession">
                        <div class="animate-spin-custom flex items-center justify-center">
                            <i class="ph-bold ph-spinner text-xl"></i>
                        </div>
                    </span>
                </button>
                <h1 class="text-xl font-bold text-sigedra-text-medium leading-tight">Detalles de la Sesión</h1>
            </div>
            <div x-data="{ loading: false }">
                <button @click="loading = true; window.location.href='{{ route('attendance.edit', $session->id) }}'" :disabled="loading" class="hidden lg:inline-flex min-w-[150px] py-2 px-3 items-center justify-center gap-x-2 text-sm font-semibold rounded-md border bg-sigedra-components-bg text-sigedra-text-medium hover:bg-sigedra-components-hover-bg focus:outline-none focus:sigedra-components-hover-bg transition-colors">
                    <span x-show="!loading" class="flex items-center gap-x-2">
                        <i class="ph ph-pencil-simple text-lg"></i>
                        <span>Editar sesión</span>
                    </span>
                    <span x-show="loading" style="display: none;">
                        <div class="animate-spin-custom flex items-center justify-center">
                            <i class="ph-bold ph-spinner text-xl"></i>
                        </div>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <div class="space-y-4">
        <div class="bg-sigedra-light-bg border rounded-lg p-4">
            <div class="flex flex-wrap items-center gap-2">
                <x-info-badge icon="calendar-blank" class="rounded-full text-sigedra-text-medium px-3">
                    {{ $session->fecha->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </x-info-badge>
                <x-info-badge icon="arrows-clockwise">{{ $session->ciclo->tipoCiclo->nombre }}</x-info-badge>
                <x-info-badge icon="book-bookmark">{{ $session->cargaAcademica->materia->nombre }}</x-info-badge>
                <x-info-badge icon="graduation-cap">{{ $session->cargaAcademica->grado->nivelAcademico->nombre }} ({{ $session->cargaAcademica->grado->anioAcademico->anio }})</x-info-badge>
                <x-info-badge icon="chalkboard-teacher">{{ $session->cargaAcademica->maestro->nombre_completo }}</x-info-badge>
            </div>
        </div>

        <div class="overflow-x-auto hidden md:block">
            <x-table>
                <x-slot:head>
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]">
                            #
                        </th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">
                            Cédula
                        </th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]">
                            Nombre completo
                        </th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[35%]">
                            Observaciones
                        </th>
                    </tr>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($studentDetails as $asistencia)
                    <tr class="hover:bg-sigedra-medium-bg">
                        <td class="px-6 py-3 text-base font-medium text-sigedra-text-dark">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark">{{ $asistencia->estudiante->cedula }}
                        </td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark truncate" title="{{ $asistencia->estudiante->nombre_completo }}">{{
                            $asistencia->estudiante->nombre_completo }}
                        </td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark">
                            <span class="inline-flex w-24 items-center justify-center px-2.5 py-0.5 rounded-lg text-sm font-medium border
    @switch($asistencia->estadoAsistencia->nombre)
        @case('Presente')  bg-green-100 text-green-800 border-green-200 @break
        @case('Ausente')   bg-red-100 text-red-800 border-red-200 @break
        @case('Tardía')    bg-yellow-100 text-yellow-800 border-yellow-200 @break
        @default           bg-gray-100 text-gray-800 border-gray-200
    @endswitch
">
                                {{ $asistencia->estadoAsistencia->nombre }}
                            </span>

                        </td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark">{{ $asistencia->observaciones ?? '-'
                            }}
                        </td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay estudiantes registrados en esta sesión." />
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>

        <div class="block md:hidden bg-sigedra-light-bg border rounded-lg divide-y">
            @forelse ($studentDetails as $asistencia)
            <div class="p-4">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex items-center gap-3">
                        <span class="flex-shrink-0 w-7 h-7 rounded-full bg-sigedra-primary text-white flex items-center justify-center font-bold text-xs">
                            {{ $loop->iteration }}
                        </span>
                        <div>
                            <p class="font-bold text-sigedra-text-dark">{{ $asistencia->estudiante->nombre_completo }}</p>
                            <p class="text-sm text-sigedra-text-medium">{{ $asistencia->estudiante->cedula }}</p>
                        </div>
                    </div>
                    <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-lg text-sm font-medium border
                            @switch($asistencia->estadoAsistencia->nombre)
                                @case('Presente')  bg-green-100 text-green-800 border-green-200 @break
                                @case('Ausente')   bg-red-100 text-red-800 border-red-200 @break
                                @case('Tardía')    bg-yellow-100 text-yellow-800 border-yellow-200 @break
                                @default           bg-gray-100 text-gray-800 border-gray-200
                            @endswitch
                        ">
                        {{ $asistencia->estadoAsistencia->nombre }}
                    </span>
                </div>
                @if ($asistencia->observaciones)
                <div class="mt-2">
                    <p class="text-sm text-sigedra-text-medium"><span class="font-semibold text-sigedra-text-dark">Observaciones:</span> {{ $asistencia->observaciones }}</p>
                </div>
                @endif
            </div>
            @empty
            <div class="p-4 text-center text-sigedra-text-medium">
                <p>No hay estudiantes registrados en esta sesión.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- INICIO: Footer para Móviles -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 z-10" x-data="{ loading: false }">
        <button @click="loading = true; window.location.href='{{ route('attendance.edit', $session->id) }}'" :disabled="loading" class="w-full justify-center py-3 py-2 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-primary text-white hover:bg-sigedra-primary-dark focus:outline-none focus:bg-sigedra-primary-dark transition-all shadow-sm">
            <span x-show="!loading" class="flex items-center gap-x-2">
                <i class="ph ph-pencil-simple text-lg"></i>
                <span>Editar sesión</span>
            </span>
            <span x-show="loading" style="display: none;">
                <div class="animate-spin-custom flex items-center justify-center">
                    <i class="ph-bold ph-spinner text-xl"></i>
                </div>
            </span>
        </button>
    </div>
    <!-- FIN: Footer para Móviles -->

    @else
    <div class="animate-pulse">
        <!-- Skeleton Header -->
        <div class="container mx-auto px-0 py-5 flex items-center justify-between">
            <div class="flex items-baseline gap-x-2">
                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                <div class="h-7 w-48 bg-gray-200 rounded"></div>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Skeleton Info Pills -->
            <div class="bg-white border rounded-lg p-4">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="h-7 w-64 bg-gray-200 rounded-full"></div>
                    <div class="h-7 w-40 bg-gray-200 rounded-md"></div>
                    <div class="h-7 w-52 bg-gray-200 rounded-md"></div>
                    <div class="h-7 w-48 bg-gray-200 rounded-md"></div>
                </div>
            </div>

            <!-- Skeleton Tabla Desktop -->
            <div class="hidden md:block bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <div class="flex items-center gap-x-4">
                        <div class="h-6 bg-gray-300 rounded w-full"></div>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @for ($i = 0; $i < 5; $i++)
                    <div class="px-6 py-3">
                        <div class="flex items-center gap-x-4">
                            <div class="h-[38px] bg-gray-200 rounded w-[5%]"></div>
                            <div class="h-[38px] bg-gray-200 rounded w-[15%]"></div>
                            <div class="h-[38px] bg-gray-200 rounded w-[30%]"></div>
                            <div class="h-[38px] bg-gray-200 rounded w-[15%]"></div>
                            <div class="h-[38px] bg-gray-200 rounded w-[35%]"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Skeleton Cards Mobile -->
            <div class="block md:hidden bg-white border rounded-lg divide-y">
                @for ($i = 0; $i < 5; $i++)
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div class="space-y-2">
                            <div class="h-5 w-40 bg-gray-200 rounded"></div>
                            <div class="h-4 w-24 bg-gray-200 rounded"></div>
                        </div>
                        <div class="h-6 w-20 bg-gray-200 rounded-lg"></div>
                    </div>
                    <div class="mt-4">
                        <div class="h-4 w-full bg-gray-200 rounded"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
    @endif
</div>