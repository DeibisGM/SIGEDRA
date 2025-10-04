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

<div x-data="attendanceForm()">
    <div x-show="showError" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" style="display: none;">
        <span class="block sm:inline">Debe seleccionar el estado de asistencia para todos los estudiantes.</span>
    </div>
    <form method="POST" action="{{ $formAction }}" id="attendance-form" @submit="validateForm($event)">
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
            @if(!$sesionAsistencia)
            <div class="flex justify-end">
                <div class="flex gap-3 w-full md:w-auto">
                    <x-secondary-button @click="markAllPresent()" type="button" class="w-full md:w-auto justify-center text-sm" title="Marcar todos como presentes">
                        <i class="ph ph-check-square-offset text-lg"></i>
                        <span class="sm:inline">Todos Presentes</span>
                    </x-secondary-button>
                </div>
            </div>
            @endif

            {{-- Tabla de Estudiantes --}}
            <div class="overflow-x-auto -mx-4 md:mx-0 border border-sigedra-border rounded-lg">
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
                            <td class="px-6 py-3 text-base font-medium text-sigedra-text-dark">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark">{{ $student->cedula }}</td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark font-medium">{{ $student->nombre_completo }}</td>
                            <td class="px-6 py-3 text-base text-sigedra-text-dark">
                                <div x-data="{ status: {{ $asistencia->estado_asistencia_id ?? 0 }} }" @if(!$sesionAsistencia) @mark-all-present.window="status = 1" @endif class="flex items-center gap-1.5">
                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="1" id="presente-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="presente-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-base font-medium rounded-md border" :class="{
                                            'bg-green-100 text-green-800 border-green-300': status == 1,
                                            'bg-white hover:bg-gray-50 text-gray-700': status != 1
                                        }">Presente</label>

                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="3" id="tardia-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="tardia-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-base font-medium rounded-md border" :class="{
                                            'bg-yellow-100 text-yellow-800 border-yellow-300': status == 3,
                                            'bg-white hover:bg-gray-50 text-gray-700': status != 3
                                        }">Tardía</label>

                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="4" id="justificado-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="justificado-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-base font-medium rounded-md border" :class="{
                                            'bg-blue-100 text-blue-800 border-blue-300': status == 4,
                                            'bg-white hover:bg-gray-50 text-gray-700': status != 4
                                        }">Justificado</label>

                                    <input type="radio" name="asistencias[{{ $student->id }}][estado_asistencia_id]" value="2" id="ausente-{{ $student->id }}" x-model.number="status" class="hidden">
                                    <label for="ausente-{{ $student->id }}" class="cursor-pointer px-3 py-1.5 text-base font-medium rounded-md border" :class="{
                                            'bg-red-100 text-red-800 border-red-300': status == 2,
                                            'bg-white hover:bg-gray-50 text-gray-700': status != 2
                                        }">Ausente</label>
                                </div>
                            </td>
                            <td class="px-6 text-base text-sigedra-text-dark">
                                <x-text-input
                                    type="text"
                                    name="asistencias[{{ $student->id }}][observaciones]"
                                    class="w-full text-base py-1.5"
                                    placeholder="Añada una observación..."
                                    value="{{ $asistencia->observaciones ?? '' }}"
                                />
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
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('attendanceForm', () => ({
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
                    this.showError = true;
                    setTimeout(() => this.showError = false, 5000);
                }
            }
        }));
    });
</script>
@endpush
