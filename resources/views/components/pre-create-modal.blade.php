@props(['cargasAcademicas', 'tiposCiclo'])

<x-modal name="pre-create-modal">
    <div class="p-6" x-data="{
        carga_academica_id: '',
        tipo_ciclo_id: '',
        date: '',
        cargas: {{ json_encode($cargasAcademicas->map(function($carga) {
            return [
                'id' => $carga->id,
                'text' => $carga->materia->nombre . ' - ' . $carga->grado->nivelAcademico->nombre . ' (' . $carga->grado->anioAcademico->anio . ')'
            ];
        })) }},
        ciclos: {{ json_encode($tiposCiclo->map(function($ciclo) {
            return [
                'id' => $ciclo->id,
                'text' => $ciclo->nombre
            ];
        })) }},
        selectedCargaText: 'Seleccione un curso',
        selectedCicloText: 'Seleccione un ciclo',
        showValidationError: false,
        loading: false,
        reset() {
            this.carga_academica_id = '';
            this.tipo_ciclo_id = '';
            this.selectedCargaText = 'Seleccione un curso';
            this.selectedCicloText = 'Seleccione un ciclo';
            this.showValidationError = false;
            this.loading = false;
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            this.date = `${year}-${month}-${day}`;
        }
    }" x-init="reset()" @open-modal.window="if ($event.detail == 'pre-create-modal') { reset() }">
        <h2 class="text-lg font-medium text-sigedra-text-dark">
            Seleccionar Curso, Ciclo y Fecha
        </h2>

        <p class="mt-1 text-base text-sigedra-text-medium">
            Por favor, selecciona la materia, el ciclo y la fecha para pasar lista.
        </p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Selector de Materia -->
            <div x-data="{ open: false }" class="relative">
                <x-input-label for="carga_academica_id" value="Materia" />
                <x-filter-button @click="open = !open">
                    <span x-text="selectedCargaText"></span>
                </x-filter-button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white rounded-md border" style="display: none;">
                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-sigedra-border ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <template x-for="carga in cargas" :key="carga.id">
                            <li class="px-3 py-2 text-sigedra-text-dark cursor-pointer hover:bg-sigedra-light-colored-bg"
                                @click="carga_academica_id = carga.id; selectedCargaText = carga.text; open = false; showValidationError = false">
                                <span x-text="carga.text"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <!-- Selector de Ciclo -->
            <div x-data="{ open: false }" class="relative">
                <x-input-label for="tipo_ciclo_id" value="Ciclo" />
                <x-filter-button @click="open = !open">
                    <span x-text="selectedCicloText"></span>
                </x-filter-button>
                <div x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white rounded-md border" style="display: none;">
                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-sigedra-border ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                        <template x-for="ciclo in ciclos" :key="ciclo.id">
                            <li class="px-3 py-2 text-sigedra-text-dark cursor-pointer hover:bg-sigedra-light-colored-bg"
                                @click="tipo_ciclo_id = ciclo.id; selectedCicloText = ciclo.text; open = false; showValidationError = false">
                                <span x-text="ciclo.text"></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div>
                <x-input-label for="date" value="Fecha" />
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 end-0 flex items-center pe-3.5 pointer-events-none">
                        <i class="ph ph-calendar-blank w-4 h-4 text-sigedra-text-medium"></i>
                    </div>
                    <input datepicker datepicker-buttons datepicker-autohide datepicker-format="yyyy-mm-dd" datepicker-autoselect-today id="date" type="text" class="custom-datepicker h-11 bg-white border border-sigedra-border text-sigedra-text-dark text-sm rounded-lg focus:border-sigedra-text-medium block w-full pe-10 p-2.5" placeholder="Seleccionar fecha" x-model="date" required autocomplete="off" @change="showValidationError = false">
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-col md:flex-row md:items-center gap-3">
            <!-- Mensaje de error -->
            <p x-show="showValidationError && (!carga_academica_id || !tipo_ciclo_id || !date)" class="text-sm text-red-600 text-center md:text-left" style="display: none;">
                Seleccione un curso, ciclo y fecha.
            </p>

            <!-- Contenedor de botones -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 w-full sm:w-auto md:ml-auto">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-full sm:w-auto justify-center">
                    Cancelar
                </x-secondary-button>

                <x-primary-loading-button
                    as="button"
                    x-on:click="
                        loading = true;
                        if(carga_academica_id && tipo_ciclo_id && date) {
                            window.location.href = `{{ route('attendance.create') }}?carga_academica_id=${carga_academica_id}&tipo_ciclo_id=${tipo_ciclo_id}&fecha=${date}`;
                        } else {
                            loading = false;
                            showValidationError = true;
                        }
                    "
                    class="w-full sm:w-auto justify-center min-w-[150px]"
                    loading="loading"
                >
                    Continuar
                </x-primary-loading-button>
            </div>
        </div>
    </div>
</x-modal>