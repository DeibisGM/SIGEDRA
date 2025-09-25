@props(['attendance'])

@php
$total = $attendance['present'] + $attendance['absent'] + $attendance['late'];
$percent = $total > 0 ? round(($attendance['present'] / $total) * 100) : 0;
@endphp

<tr class="bg-white hover:bg-gray-50">
    <td class="px-6 py-4 text-base text-gray-800">{{ $attendance['date'] }}</td>
    <td class="px-6 py-4 text-base font-medium text-gray-800">{{ $attendance['course'] }}</td>
    <td class="px-6 py-4 text-base text-gray-800 text-center">
    <div class="flex items-center justify-center gap-x-2">
        <span class="h-2 w-2 rounded-full bg-green-500"></span>
        <span>{{ $attendance['present'] }}</span>
    </div>
</td>
<td class="px-6 py-4 text-base text-gray-800 text-center">
    <div class="flex items-center justify-center gap-x-2">
        <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
        <span>{{ $attendance['late'] }}</span>
    </div>
</td>
<td class="px-6 py-4 text-base text-gray-800 text-center">
    <div class="flex items-center justify-center gap-x-2">
        <span class="h-2 w-2 rounded-full bg-red-500"></span>
        <span>{{ $attendance['absent'] }}</span>
    </div>
</td>
    <td class="px-6 py-4 text-base text-gray-800 text-center">{{ $percent }}%</td>
    <td class="px-6 py-4 text-base font-medium">
        <div class="w-full flex items-center justify-start gap-x-2">
            <x-buttons.secondary href="#" title="Ver Detalles">
                <i class="ph ph-eye text-lg"></i>
            </x-buttons.secondary>
            <x-buttons.secondary href="#" title="Editar">
                <i class="ph ph-pencil-simple text-lg"></i>
            </x-buttons.secondary>
            <x-buttons.danger-secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-attendance-deletion')" title="Eliminar">
                <i class="ph ph-trash text-lg"></i>
            </x-buttons.danger-secondary>
        </div>
    </td>
</tr>
