@props(['attendance'])

@php
$total = $attendance['present'] + $attendance['absent'] + $attendance['late'];
$percent = $total > 0 ? round(($attendance['present'] / $total) * 100) : 0;
@endphp

<tr class="block md:table-row md:odd:bg-white md:even:bg-sigedra-input/40 border-b border-sigedra-border last:border-b-0">
    <!-- Mobile Card View -->
    <td class="block md:hidden" colspan="7">
        <div class="p-4 bg-white">
            <div class="flex justify-between items-start">
                <div class="flex-grow overflow-hidden pr-4">
                    <p class="text-sm text-gray-800">5to Grado 2025</p>
                    <p class="font-semibold text-gray-800 truncate">{{ $attendance['course'] }}</p>
                </div>
                <div x-data="{ open: false }" class="relative flex-shrink-0">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100 -mt-2">
                        <i class="ph ph-dots-three-vertical text-xl"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-1 z-20" x-cloak>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="ph ph-eye"></i> Ver
                        </a>
                        <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="ph ph-pencil-simple"></i> Editar
                        </a>
                        <a href="#" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-attendance-deletion')" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="ph ph-trash"></i> Eliminar
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 text-sm mt-3">
                @php
                    $priorityClass = 'bg-red-100 text-red-800';
                    $priorityText = 'Asistencia Baja';
                    if ($percent >= 90) {
                        $priorityClass = 'bg-green-100 text-green-800';
                        $priorityText = 'Asistencia Alta';
                    } elseif ($percent >= 70) {
                        $priorityClass = 'bg-yellow-100 text-yellow-800';
                        $priorityText = 'Asistencia Media';
                    }
                @endphp
                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium whitespace-nowrap {{ $priorityClass }}">
                    {{ $priorityText }}
                </span>
                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-full text-xs font-medium whitespace-nowrap bg-gray-100 text-gray-800">
                    <i class="ph ph-calendar"></i>
                    {{ $attendance['date'] }}
                </span>
            </div>
        </div>
    </td>

    <!-- Desktop Table View -->
    <td class="hidden md:table-cell px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['date'] }}</td>
    <td class="hidden md:table-cell px-6 py-4 font-medium text-sigedra-text-dark">{{ $attendance['course'] }}</td>
    <td class="hidden md:table-cell px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['present'] }}</td>
    <td class="hidden md:table-cell px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['absent'] }}</td>
    <td class="hidden md:table-cell px-6 py-4 text-base text-sigedra-text-medium">{{ $attendance['late'] }}</td>
    <td class="hidden md:table-cell px-6 py-4 text-base text-sigedra-text-medium">{{ $percent }}%</td>
    <td class="hidden md:table-cell px-6 py-4 text-base font-medium">
        <div class="flex items-center space-x-2">
            <x-buttons.secondary href="#"><i class="ph ph-eye"></i></x-buttons.secondary>
            <x-buttons.secondary href="#"><i class="ph ph-pencil-simple"></i></x-buttons.secondary>
            <x-buttons.danger-secondary x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-attendance-deletion')"><i class="ph ph-trash"></i></x-buttons.danger-secondary>
        </div>
    </td>
</tr>
