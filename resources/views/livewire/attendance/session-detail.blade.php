<div class="relative min-h-[400px]">
    @if ($session)
    <header class="">
    <div class="container mx-auto px-0 py-5 flex items-center justify-between">
        <div class="flex items-baseline gap-x-2">
            <button
                wire:click="closeSession"
                wire:loading.attr="disabled"
                wire:target="closeSession"
                class="text-sigedra-text-medium hover:text-sigedra-text-dark transition-colors p-1 rounded-full hover:bg-sigedra-light-colored-bg disabled:opacity-50"
                title="Volver al historial"
            >
                <span wire:loading wire:target="closeSession"><i
                        class="ph ph-spinner-gap text-xl animate-spin"></i></span>
                <span wire:loading.remove wire:target="closeSession"><i class="ph ph-arrow-left text-xl"></i></span>
            </button>
            <h1 class="text-xl font-bold text-sigedra-text-medium leading-tight">Detalles de la Sesión</h1>
        </div>
        <x-secondary-button wire:click="editSession">
            <i class="ph ph-pencil-simple text-lg"></i>
            <span>Editar sesión</span>
        </x-secondary-button>
    </div>
</header>

    <div class="space-y-4">
        <div class="bg-sigedra-light-bg border rounded-lg p-4">
            <div class="flex flex-wrap items-center gap-2">
                <div
                    class="inline-flex items-center gap-x-2 bg-sigedra-medium-bg text-sigedra-text-medium px-3 py-1 rounded-full border">
                    <i class="ph ph-calendar text-lg"></i>
                    <span class="text-sm font-medium">{{ $session->fecha->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
                </div>
                <span
                    class="inline-flex items-center gap-x-1.5 bg-sigedra-medium-bg text-sigedra-text-dark text-sm font-medium px-2.5 py-1 rounded-md border">
                        <i class="ph ph-book-bookmark text-base"></i>
                        {{ $session->cargaAcademica->materia->nombre }}
                    </span>
                <span
                    class="inline-flex items-center gap-x-1.5 bg-sigedra-medium-bg text-sigedra-text-dark text-sm font-medium px-2.5 py-1 rounded-md border">
                        <i class="ph ph-graduation-cap text-base"></i>
                        {{ $session->cargaAcademica->grado->nivelAcademico->nombre }} ({{ $session->cargaAcademica->grado->anioAcademico->anio }})
                    </span>
                <span
                    class="inline-flex items-center gap-x-1.5 bg-sigedra-medium-bg text-sigedra-text-dark text-sm font-medium px-2.5 py-1 rounded-md border">
                        <i class="ph ph-chalkboard-teacher text-base"></i>
                        {{ $session->cargaAcademica->maestro->nombre_completo }}
                    </span>
            </div>
        </div>

        <div class="overflow-x-auto hidden md:block">
            <x-table>
                <x-slot:head>
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]  ">
                            #
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]  ">
                            Cédula
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]  ">
                            Nombre completo
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[15%]  ">
                            Estado
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[35%]  ">
                            Observaciones
                        </th>
                    </tr>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($studentDetails as $asistencia)
                    <tr class="hover:bg-sigedra-medium-bg">
                        <td class="px-6 py-3 text-base font-medium text-sigedra-text-dark  ">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark  ">{{ $asistencia->estudiante->cedula }}
                        </td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark truncate  "
                            title="{{ $asistencia->estudiante->nombre_completo }}">{{
                            $asistencia->estudiante->nombre_completo }}
                        </td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark">
               <span class="inline-flex w-24 items-center justify-center px-2.5 py-0.5 rounded-lg text-sm font-medium border
    @switch($asistencia->estadoAsistencia->nombre)
        @case('Presente')  bg-sigedra-accent/10 border-sigedra-accent/50 text-sigedra-accent @break
        @case('Ausente')   bg-sigedra-error/10 border-sigedra-error/50 text-sigedra-error @break
        @case('Tardía')    bg-sigedra-warning/10 border-sigedra-warning/50 text-sigedra-warning @break
        @default           bg-sigedra-medium-bg/10 border-sigedra-text-medium/50 text-sigedra-text-medium
    @endswitch
">
    {{ $asistencia->estadoAsistencia->nombre }}
</span>

                        </td>
                        <td class="px-6 py-3 text-base text-sigedra-text-dark  ">{{ $asistencia->observaciones ?? '-'
                            }}
                        </td>
                    </tr>
                    @empty
                    <x-empty-state message="No hay estudiantes registrados en esta sesión."/>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>

        <div class="block md:hidden space-y-2">
            @forelse ($studentDetails as $asistencia)
            <div class="bg-sigedra-light-bg border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-bold text-lg">{{ $asistencia->estudiante->nombre_completo }}</p>
                        <p class="text-sm text-sigedra-text-medium">{{ $asistencia->estudiante->cedula }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-sm font-medium
                            @switch($asistencia->estadoAsistencia->nombre)
        @case('Presente')  bg-sigedra-accent/10 border-sigedra-accent/50 text-sigedra-accent @break
        @case('Ausente')   bg-sigedra-error/10 border-sigedra-error/50 text-sigedra-error @break
        @case('Tardía')    bg-sigedra-warning/10 border-sigedra-warning/50 text-sigedra-warning @break
        @default           bg-sigedra-medium-bg/10 border-sigedra-text-medium/50 text-sigedra-text-medium
                            @endswitch
                        ">
                            {{ $asistencia->estadoAsistencia->nombre }}
                        </span>
                </div>
                @if ($asistencia->observaciones)
                <div class="mt-4">
                    <p class="text-sm"><span class="font-semibold">Observaciones:</span> {{ $asistencia->observaciones
                        }}</p>
                </div>
                @endif
            </div>
            @empty
            <div class="text-center py-10">
                <p>No hay estudiantes registrados en esta sesión.</p>
            </div>
            @endforelse
        </div>
    </div>
    @else
    <div class="animate-pulse">
        <div class="flex justify-between items-center gap-x-4 mb-4 mt-4">
            <div class="flex items-center gap-x-2">
                <div class="h-8 w-8 bg-sigedra-light-bg rounded-full"></div>
                <div class="h-6 w-48 bg-sigedra-light-bg rounded-md"></div>
            </div>
            <div class="h-9 w-24 bg-sigedra-light-bg rounded-md"></div>
        </div>
        <div class="space-y-4">
            <div class="bg-sigedra-bg border rounded-lg p-4">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="h-7 w-64 bg-sigedra-light-bg rounded-full"></div>
                    <div class="h-7 w-40 bg-sigedra-light-bg rounded-md"></div>
                    <div class="h-7 w-52 bg-sigedra-light-bg rounded-md"></div>
                    <div class="h-7 w-48 bg-sigedra-light-bg rounded-md"></div>
                </div>
            </div>
            <div class="overflow-x-auto hidden md:block">
                <div class="w-full border rounded-lg">
                    <div class="px-6 py-4 border-b bg-sigedra-medium-bg">
                        <div class="flex justify-between">
                            <div class="h-5 w-10 bg-sigedra-light-bg rounded"></div>
                            <div class="h-5 w-24 bg-sigedra-light-bg rounded"></div>
                            <div class="h-5 w-40 bg-sigedra-light-bg rounded"></div>
                            <div class="h-5 w-20 bg-sigedra-light-bg rounded"></div>
                            <div class="h-5 w-32 bg-sigedra-light-bg rounded"></div>
                        </div>
                    </div>
                    <div class="divide-y">
                        @for ($i = 0; $i < 5; $i++)
                        <div class="px-6 py-4">
                            <div class="flex justify-between items-center">
                                <div class="h-5 w-10 bg-sigedra-medium-bg rounded"></div>
                                <div class="h-5 w-24 bg-sigedra-medium-bg rounded"></div>
                                <div class="h-5 w-40 bg-sigedra-medium-bg rounded"></div>
                                <div class="h-5 w-20 bg-sigedra-medium-bg rounded-full"></div>
                                <div class="h-5 w-32 bg-sigedra-medium-bg rounded"></div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
