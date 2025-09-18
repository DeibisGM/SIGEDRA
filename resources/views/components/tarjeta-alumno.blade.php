@props(['student', 'loop'])

<tr class="hover:bg-gray-50">
    <td class="px-6 py-4 text-base text-gray-800">{{ $loop->iteration }}</td>
    <td class="px-6 py-4 text-base text-gray-800">{{ $student['cedula'] }}</td>
    <td class="px-6 py-4 text-base font-medium text-gray-800">{{ $student['nombre'] }}</td>
    <td class="px-6 py-4 text-base text-gray-800"><x-percentage-chip :percentage="$student['asistencia']" /></td>
    <td class="px-6 py-4 text-base text-gray-800 w-56"><x-attendance-select/></td>
    <td class="px-6 py-4 text-base text-gray-800">
        <input type="text" class="py-2 px-3 block w-full bg-white border-sigedra-border rounded-lg text-base placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Añadir observación...">
    </td>
</tr>
