<x-modal name="pre-create-modal">
    <div class="p-6" x-data="{ subject: 'Matemáticas Avanzadas', date: '' }">
        <h2 class="text-lg font-medium text-gray-900">
            Seleccionar Curso y Fecha
        </h2>

        <p class="mt-1 text-base text-gray-600">
            Por favor, selecciona la materia y la fecha para pasar lista.
        </p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Selector de Materia -->
            <div>
                <x-input-label for="subject" value="Materia" />
                <select id="subject" name="subject" x-model="subject" class="mt-1 block w-full py-2 px-3 border border-sigedra-border bg-white rounded-md shadow-sm focus:outline-none focus:ring-sigedra-primary focus:border-sigedra-primary sm:text-sm">
                    <option>Matemáticas Avanzadas</option>
                    <option>Ciencias Naturales</option>
                    <option>Historia</option>
                </select>
            </div>

            <div>
                <x-input-label for="date" value="Fecha" />
                <div class="relative mt-1 max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input datepicker datepicker-buttons datepicker-autohide datepicker-format="yyyy-mm-dd" datepicker-autoselect-today id="date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Seleccionar fecha" x-model="date" required autocomplete="off">
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <x-buttons.secondary x-on:click="$dispatch('close')">
                Cancelar
            </x-buttons.secondary>

            <x-buttons.primary
                as="button"
                x-on:click="window.location.href = `{{ route('attendance.create') }}?materia=${subject}&fecha=${date}`"
            >
                Continuar
            </x-buttons.primary>
        </div>
    </div>
</x-modal>
