{{-- resources/views/attendance/_form.blade.php --}}
@props([
    'formAction',
    'formMethod' => 'POST',
    'sesionAsistencia' => null,
    'cargaAcademica',
    'students' => [],
    'fecha',
    'ciclo_id',
    'cicloNombre',
])

<div x-data="attendanceForm">
    <div x-show="showError" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" style="display: none;">
        <span class="block sm:inline">Debe seleccionar el estado de asistencia para todos los estudiantes.</span>
    </div>
    <form method="POST" action="{{ $formAction }}" id="attendance-form" @submit="loading = true; validateForm($event)">
        @csrf
        @if($formMethod !== 'POST')
            @method($formMethod)
        @endif

        <input type="hidden" name="carga_academica_id" value="{{ $cargaAcademica->id }}">
        <input type="hidden" name="ciclo_id" value="{{ $ciclo_id }}">
        <input type="hidden" name="fecha" value="{{ $fecha }}">

        <div class="space-y-6">
            {{-- Información del Curso y Fecha --}}
            <div class="bg-sigedra-light-bg border rounded-lg p-4">
                <div class="flex flex-wrap items-center gap-2">
                    <x-info-badge icon="calendar-blank" class="rounded-full text-sigedra-text-medium px-3">
                        {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </x-info-badge>
                    <x-info-badge icon="arrows-clockwise">{{ $cicloNombre }}</x-info-badge>
                    <x-info-badge icon="book-bookmark">{{ $cargaAcademica->materia->nombre }}</x-info-badge>
                    <x-info-badge icon="graduation-cap">{{ $cargaAcademica->grado->nivelAcademico->nombre }} ({{ $cargaAcademica->grado->anioAcademico->anio }})</x-info-badge>
                    <x-info-badge icon="chalkboard-teacher">{{ $cargaAcademica->maestro->nombre_completo }}</x-info-badge>
                </div>
            </div>

            {{-- Acciones Secundarias --}}
            <div class="flex justify-end">
                <div class="flex gap-3 w-full md:w-auto">
                    <x-secondary-button @click="markAllPresent()" type="button" class="w-full md:w-auto justify-center text-sm" title="Marcar todos como presentes">
                        <i class="ph ph-check-square-offset text-lg"></i>
                        <span class="sm:inline">Todos Presentes</span>
                    </x-secondary-button>
                </div>
            </div>

            {{-- Tabla de Estudiantes (Desktop) --}}
            <div class="overflow-x-auto -mx-4 md:mx-0 border border-sigedra-border rounded-lg hidden md:block">
                <table class="min-w-full divide-y divide-sigedra-border">
                    <thead class="bg-sigedra-light-bg">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[5%]#">#</th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[10%]">Cédula</th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[25%]">Nombre completo</th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]">Asistencia</th>
                        <th scope="col" class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider w-[30%]">Observaciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-sigedra-border bg-white">
                    @php
                        $items = $sesionAsistencia ? $sesionAsistencia->asistencias : $students;
                    @endphp
                    @forelse ($items as $item)
                        @php
                            $student = $sesionAsistencia ? $item->estudiante : $item;
                            $asistencia = $sesionAsistencia ? $item : null;
                        @endphp
                        <tr>
                            <td class="px-6 py-3 text-base font-medium text-sigedra-text-dark align-middle">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark align-middle">{{ $student->cedula }}</td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark font-medium align-middle">{{ $student->nombre_completo }}</td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark align-middle">
                                <div x-data="{ status: {{ $asistencia->estado_asistencia_id ?? 0 }} }" @mark-all-present.window="status = 1" class="isolate inline-flex rounded-md">
                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="1" id="presente-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="presente-{{ $student->id }}" class="relative inline-flex items-center rounded-l-md px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer" :class="{
                                            'bg-green-100 text-green-800 ring-green-300 font-semibold': status == 1,
                                            'bg-white text-gray-900 font-normal': status != 1
                                        }">Presente</label>

                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="3" id="tardia-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="tardia-{{ $student->id }}" class="relative -ml-px inline-flex items-center px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer" :class="{
                                            'bg-yellow-100 text-yellow-800 ring-yellow-300 font-semibold': status == 3,
                                            'bg-white text-gray-900 font-normal': status != 3
                                        }">Tardía</label>

                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="4" id="justificado-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="justificado-{{ $student->id }}" class="relative -ml-px inline-flex items-center px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer" :class="{
                                            'bg-blue-100 text-blue-800 ring-blue-300 font-semibold': status == 4,
                                            'bg-white text-gray-900 font-normal': status != 4
                                        }">Justificado</label>

                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="2" id="ausente-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="ausente-{{ $student->id }}" class="relative -ml-px inline-flex items-center rounded-r-md px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer" :class="{
                                            'bg-red-100 text-red-800 ring-red-300 font-semibold': status == 2,
                                            'bg-white text-gray-900 font-normal': status != 2
                                        }">Ausente</label>
                                </div>
                            </td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark align-middle">
                                <x-textarea-input name="asistencias[{{ $student->id }}][observaciones]" rows="1" class="w-full text-base py-1.5 resize-none" placeholder="Añada una observación..." maxlength="75">{{ $asistencia->observaciones ?? '' }}</x-textarea-input>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-sigedra-text-medium">
                                <div class="flex flex-col items-center">
                                    <i class="ph ph-user-list text-5xl text-gray-400"></i>
                                    <p class="mt-2 font-semibold">No hay estudiantes en esta clase.</p>
                                    <p class="text-xs">No se encontraron estudiantes matriculados en este curso.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Lista de Estudiantes (Mobile) --}}
            <div class="block md:hidden space-y-4">
                @php
                    $items = $sesionAsistencia ? $sesionAsistencia->asistencias : $students;
                @endphp
                @forelse ($items as $item)
                    @php
                        $student = $sesionAsistencia ? $item->estudiante : $item;
                        $asistencia = $sesionAsistencia ? $item : null;
                    @endphp
                    <div class="bg-white border border-sigedra-border rounded-lg p-4 space-y-4">
                        <div>
                            <p class="font-bold text-sigedra-text-dark">{{ $student->nombre_completo }}</p>
                            <p class="text-sm text-sigedra-text-medium">Cédula: {{ $student->cedula }}</p>
                        </div>

                        <div class="border-t border-sigedra-border"></div>

                        <div>
                            <p class="text-base font-semibold text-sigedra-text-dark mb-3">Asistencia</p>
                            <div x-data="{ status: {{ $asistencia->estado_asistencia_id ?? 0 }} }" @mark-all-present.window="status = 1" class="isolate inline-flex rounded-md w-full">
                                <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="1" id="presente-m-{{ $student->id }}" x-model.number="status" class="hidden">
                                <label for="presente-m-{{ $student->id }}" class="relative inline-flex items-center justify-center rounded-l-md px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer w-1/4" :class="{
                                        'bg-green-100 text-green-800 ring-green-300 font-semibold': status == 1,
                                        'bg-white text-gray-900 font-normal': status != 1
                                    }">Pres.</label>

                                <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="3" id="tardia-m-{{ $student->id }}" x-model.number="status" class="hidden">
                                <label for="tardia-m-{{ $student->id }}" class="relative -ml-px inline-flex items-center justify-center px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer w-1/4" :class="{
                                        'bg-yellow-100 text-yellow-800 ring-yellow-300 font-semibold': status == 3,
                                        'bg-white text-gray-900 font-normal': status != 3
                                    }">Tard.</label>

                                <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="4" id="justificado-m-{{ $student->id }}" x-model.number="status" class="hidden">
                                <label for="justificado-m-{{ $student->id }}" class="relative -ml-px inline-flex items-center justify-center px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer w-1/4" :class="{
                                        'bg-blue-100 text-blue-800 ring-blue-300 font-semibold': status == 4,
                                        'bg-white text-gray-900 font-normal': status != 4
                                    }">Just.</label>

                                <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="2" id="ausente-m-{{ $student->id }}" x-model.number="status" class="hidden">
                                <label for="ausente-m-{{ $student->id }}" class="relative -ml-px inline-flex items-center justify-center rounded-r-md px-3 py-2 text-sm ring-1 ring-inset ring-gray-300 focus:z-10 cursor-pointer w-1/4" :class="{
                                        'bg-red-100 text-red-800 ring-red-300 font-semibold': status == 2,
                                        'bg-white text-gray-900 font-normal': status != 2
                                    }">Aus.</label>
                            </div>
                        </div>

                        <div>
                            <label for="observaciones-m-{{ $student->id }}" class="text-base font-semibold text-sigedra-text-dark">Observaciones</label>
                            <x-textarea-input name="asistencias[{{ $student->id }}][observaciones]" id="observaciones-m-{{ $student->id }}" rows="1" class="w-full text-base py-1.5 mt-2 resize-none" placeholder="Añada una observación..." maxlength="75">{{ $asistencia->observaciones ?? '' }}</x-textarea-input>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-sm text-sigedra-text-medium">
                        <div class="flex flex-col items-center">
                            <i class="ph ph-user-list text-5xl text-gray-400"></i>
                            <p class="mt-2 font-semibold">No hay estudiantes en esta clase.</p>
                            <p class="text-xs">No se encontraron estudiantes matriculados en este curso.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('attendanceForm', () => ({
            loading: false,
            showError: false,
            markAllPresent() {
                this.$dispatch('mark-all-present');
            },
            validateForm(event) {
                const students = document.querySelectorAll('input[name^="asistencias["]');
                const studentIds = [...new Set([...students].map(s => s.name.match(/\[(\d+)\]/)[1]))];
                let allSet = true;
                if (studentIds.length > 0) {
                    for (const id of studentIds) {
                        const radios = document.querySelectorAll(`input[name="asistencias[${id}][estado_asistencia_id]"]`);
                        if (![...radios].some(r => r.checked)) {
                            allSet = false;
                            break;
                        }
                    }
                }

                if (!allSet) {
                    event.preventDefault();
                    this.loading = false;
                    this.$dispatch('loading-stop');
                    this.showError = true;
                    setTimeout(() => this.showError = false, 5000);
                }
            }
        }));
    });
</script>
@endpush
