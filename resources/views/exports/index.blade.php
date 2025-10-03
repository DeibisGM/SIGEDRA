@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-sigedra-text-dark">Exportaciones</h1>
            <p class="text-sigedra-text-medium">Genera y descarga reportes del sistema</p>
        </div>
        <button type="button" 
                onclick="openExportModal()" 
                class="bg-sigedra-primary text-white px-4 py-2 rounded-lg hover:bg-sigedra-primary-dark transition-colors duration-200 flex items-center gap-2">
            <i class="ph ph-plus text-lg"></i>
            Nueva Exportación
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sigedra-text-medium text-sm">Total Exportaciones</p>
                    <p class="text-2xl font-bold text-sigedra-text-dark">{{ $exports->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <i class="ph ph-download-simple text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sigedra-text-medium text-sm">Completadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ $exports->where('status', 'completed')->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <i class="ph ph-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sigedra-text-medium text-sm">En Proceso</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $exports->whereIn('status', ['pending', 'processing'])->count() }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-lg">
                    <i class="ph ph-clock text-orange-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Exports Table -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-sigedra-text-dark">Historial de Exportaciones</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Formato</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registros</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamaño</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($exports as $export)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="ph ph-{{ $export->type === 'estudiantes' ? 'users' : ($export->type === 'maestros' ? 'chalkboard-teacher' : 'squares-four') }} text-lg mr-2"></i>
                                <span class="text-sm font-medium text-gray-900 capitalize">{{ $export->type }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $export->format === 'pdf' ? 'bg-red-100 text-red-800' : 
                                   ($export->format === 'excel' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ strtoupper($export->format) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($export->status)
                                @case('completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="ph ph-check-circle mr-1"></i> Completado
                                    </span>
                                    @break
                                @case('processing')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="ph ph-spinner mr-1"></i> Procesando
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <i class="ph ph-clock mr-1"></i> Pendiente
                                    </span>
                                    @break
                                @case('failed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="ph ph-x-circle mr-1"></i> Fallido
                                    </span>
                                    @break
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $export->records_count ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $export->formatted_file_size ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $export->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                @if($export->status === 'completed' && $export->file_path)
                                    <a href="{{ route('exports.download', $export) }}" 
                                       class="text-sigedra-primary hover:text-sigedra-primary-dark">
                                        <i class="ph ph-download text-lg"></i>
                                    </a>
                                @endif
                                
                                @if(in_array($export->status, ['pending', 'processing']))
                                    <button onclick="checkStatus({{ $export->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        <i class="ph ph-arrow-clockwise text-lg"></i>
                                    </button>
                                @endif
                                
                                <form action="{{ route('exports.destroy', $export) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('¿Está seguro de eliminar esta exportación?')"
                                            class="text-red-600 hover:text-red-900">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No hay exportaciones registradas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para nueva exportación -->
<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Nueva Exportación</h3>
                <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('exports.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Exportación</label>
                        <select name="type" id="type" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sigedra-primary focus:border-sigedra-primary">
                            <option value="">Seleccionar tipo</option>
                            <option value="estudiantes">Estudiantes</option>
                            <option value="maestros">Maestros</option>
                            <option value="grados">Grados</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="format" class="block text-sm font-medium text-gray-700">Formato</label>
                        <select name="format" id="format" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-sigedra-primary focus:border-sigedra-primary">
                            <option value="">Seleccionar formato</option>
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    
                    <!-- Filtros básicos -->
                    <div id="filters" class="space-y-3">
                        <div class="border-t pt-3">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Filtros (Opcional)</h4>
                            
                            <div id="estudiantesFilters" class="space-y-2 hidden">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="filters[activo]" value="1" class="mr-2">
                                        Solo estudiantes activos
                                    </label>
                                </div>
                            </div>
                            
                            <div id="maestrosFilters" class="space-y-2 hidden">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="filters[activo]" value="1" class="mr-2">
                                        Solo maestros activos
                                    </label>
                                </div>
                            </div>
                            
                            <div id="gradosFilters" class="space-y-2 hidden">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="filters[activo]" value="1" class="mr-2">
                                        Solo grados activos
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeExportModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-sigedra-primary rounded-md hover:bg-sigedra-primary-dark">
                        Generar Exportación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
}

// Mostrar filtros según el tipo seleccionado
document.getElementById('type').addEventListener('change', function() {
    const filters = ['estudiantesFilters', 'maestrosFilters', 'gradosFilters'];
    filters.forEach(filter => {
        document.getElementById(filter).classList.add('hidden');
    });
    
    if (this.value) {
        document.getElementById(this.value + 'Filters').classList.remove('hidden');
    }
});

function checkStatus(exportId) {
    fetch(`/exports/${exportId}/status`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'completed') {
                location.reload();
            } else {
                alert(`Estado actual: ${data.status}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Auto-refresh para exportaciones en proceso
setInterval(() => {
    const processingRows = document.querySelectorAll('[data-status="processing"], [data-status="pending"]');
    if (processingRows.length > 0) {
        location.reload();
    }
}, 10000); // Cada 10 segundos
</script>
@endsection