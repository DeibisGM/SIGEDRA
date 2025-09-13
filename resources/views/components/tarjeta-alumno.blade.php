@props(['student', 'loop'])

<tr class="block md:table-row md:odd:bg-white md:even:bg-sigedra-input/40">
    {{-- Mobile Card View --}}
    <td class="block md:hidden" colspan="6">
        <div class="p-3 border rounded-lg border-sigedra-border mb-3">
            {{-- Card Header --}}
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-base">{{ $student['nombre'] }}</p>
                    <p class="text-sm text-sigedra-text-medium">{{ $student['cedula'] }}</p>
                </div>
                <x-percentage-chip :percentage="$student['asistencia']" />
            </div>

            {{-- Card Body --}}
            <div class="mt-3 space-y-3">
                <div class="flex items-center justify-between">
                    <label class="text-sm font-medium text-sigedra-text-medium">Estado:</label>
                    <div class="w-2/3">
                        <x-attendance-select/>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-sigedra-text-medium sr-only" for="observaciones-{{ $student['cedula'] }}">Observaciones:</label>
                    <textarea id="observaciones-{{ $student['cedula'] }}" rows="2" class="py-1 px-2 block w-full border-sigedra-border rounded-lg text-sm" placeholder="Añadir observación..."></textarea>
                </div>
            </div>
        </div>
    </td>

    {{-- Desktop Table View --}}
    <td class="hidden md:table-cell px-6 py-3">{{ $loop->iteration }}</td>
    <td class="hidden md:table-cell px-6 py-3">{{ $student['cedula'] }}</td>
    <td class="hidden md:table-cell px-6 py-3 font-medium text-sigedra-text-dark">{{ $student['nombre'] }}</td>
    <td class="hidden md:table-cell px-6 py-3"><x-percentage-chip :percentage="$student['asistencia']" /></td>
    <td class="hidden md:table-cell px-6 py-3 w-56"><x-attendance-select/></td>
    <td class="hidden md:table-cell px-6 py-3">
        <input type="text" class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-base placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añadir observación...">
    </td>
</tr>
