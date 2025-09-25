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

            <!-- Selector de Fecha -->
            <div>
                <x-input-label for="date" value="Fecha" />
                <x-text-input id="date" class="block mt-1 w-full flatpickr" type="text" name="date" x-model="date" placeholder="dd/mm/yyyy" required />
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
