@props(['student', 'loop'])

<tr class="block md:table-row mb-4 md:mb-0 bg-white rounded-lg shadow-md md:shadow-none md:odd:bg-white md:even:bg-sigedra-input/40">
    <td class="block md:table-cell px-4 py-3 md:px-6 md:py-3 border-b md:border-b-0 text-right md:text-left">
        <span class="font-bold md:hidden float-left">#:</span>
        {{ $loop->iteration }}
    </td>
    <td class="block md:table-cell px-4 py-3 md:px-6 md:py-3 border-b md:border-b-0 text-right md:text-left">
        <span class="font-bold md:hidden float-left">Cédula:</span>
        {{ $student['cedula'] }}
    </td>
    <td class="block md:table-cell px-4 py-3 md:px-6 md:py-3 border-b md:border-b-0 text-right md:text-left">
        <span class="font-bold md:hidden float-left">Nombre:</span>
        {{ $student['nombre'] }}
    </td>
    <td class="block md:table-cell px-4 py-3 md:px-6 md:py-3 border-b md:border-b-0 text-right md:text-left">
        <span class="font-bold md:hidden float-left">Asistencia:</span>
        <x-percentage-chip :percentage="$student['asistencia']" />
    </td>
    <td class="block md:table-cell px-4 py-3 md:px-6 md:py-3 w-full md:w-56 border-b md:border-b-0">
        <div class="flex justify-between items-center md:justify-start">
            <span class="font-bold md:hidden">Estado:</span>
            <div class="w-1/2 md:w-full">
                <x-attendance-select/>
            </div>
        </div>
    </td>
    <td class="block md:table-cell px-4 py-3 md:px-6 md:py-3">
            <div class="flex justify-between items-center md:justify-start">
            <span class="font-bold md:hidden">Observaciones:</span>
            <div class="w-1/2 md:w-full">
                <input type="text" class="py-2 px-3 block w-full bg-white border rounded-lg text-base text-sigedra-text-dark placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añadir observación...">
            </div>
        </div>
    </td>
</tr>
