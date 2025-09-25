@props(['courses', 'history'])

<!-- Sección del Año Lectivo Actual -->
<div class="bg-white border border-sigedra-border rounded-lg p-6">
    <h3 class="text-xl font-semibold mb-6">Año Lectivo Actual: {{ now()->year }}</h3>
    <x-table class="-mx-6 md:mx-0">
        <x-slot:head>
            <tr>
                <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Materia</th>
                <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Maestro</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">I Periodo</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">II Periodo</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Promedio</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Estado</th>
            </tr>
        </x-slot:head>
        <x-slot:body>
            @forelse ($courses as $course)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $course['materia'] }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $course['maestro'] }}</td>
                <td class="px-6 py-4 text-center text-gray-800">{{ $course['periodo_1'] }}</td>
                <td class="px-6 py-4 text-center text-gray-800">{{ $course['periodo_2'] }}</td>
                <td class="px-6 py-4 text-center font-bold text-gray-800">{{ $course['promedio'] }}</td>
                <td class="px-6 py-4 text-center">
                    <span @class([
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    'bg-green-100 text-green-800' => $course['estado'] === 'Aprobado',
                    'bg-red-100 text-red-800' => $course['estado'] === 'Reprobado',
                    ])>
                    {{ $course['estado'] }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay cursos matriculados para el año actual.</td>
            </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>

<!-- Sección de Historial de Años Anteriores -->
<div class="bg-white border border-sigedra-border rounded-lg p-6">
    <h3 class="text-xl font-semibold mb-6">Historial de Años Anteriores</h3>
    <x-table class="-mx-6 md:mx-0">
        <x-slot:head>
            <tr>
                <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Año Lectivo</th>
                <th class="px-6 py-3 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Grado Cursado</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Promedio Final</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Estado Final</th>
            </tr>
        </x-slot:head>
        <x-slot:body>
            @forelse ($history as $record)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $record['año'] }}</td>
                <td class="px-6 py-4 text-gray-800">{{ $record['grado'] }}</td>
                <td class="px-6 py-4 text-center font-bold text-gray-800">{{ $record['promedio_final'] }}</td>
                <td class="px-6 py-4 text-center">
                    <span @class([
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    'bg-green-100 text-green-800' => $record['estado'] === 'Aprobado',
                    'bg-red-100 text-red-800' => $record['estado'] === 'Reprobado',
                    ])>
                    {{ $record['estado'] }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay historial de años anteriores disponible.</td>
            </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</div>
