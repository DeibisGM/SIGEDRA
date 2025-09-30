@extends('layouts.app')

@section('title', 'Bitácora del Sistema')

@section('breadcrumbs')
<div class="text-base text-sigedra-text-medium whitespace-nowrap truncate">
    <a href="{{ route('bitacora.index') }}" class="hover:text-sigedra-text-dark">Bitácora</a>
    <span class="mx-2">/</span>
    <span>Registro de Actividad</span>
</div>
@endsection

@section('module_title', 'Bitácora del Sistema')
@section('module_subtitle', 'Rastrea la actividad de los usuarios, incluyendo acciones, fechas y detalles.')

@section('header_actions')
<div class="flex items-center gap-x-3">
    <!-- Barra de Búsqueda -->
    <div class="relative hidden sm:block">
        <input type="text" class="py-2 px-4 ps-11 block w-full bg-white border-sigedra-border rounded-lg text-sm placeholder-sigedra-text-light focus:border-sigedra-primary focus:ring-sigedra-primary" placeholder="Buscar en bitácora...">
        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
            <i class="ph ph-magnifying-glass text-lg text-sigedra-text-medium"></i>
        </div>
    </div>

    <!-- Botón de Filtros -->
    <div x-data="{ open: false }" class="relative">
        <x-secondary-button @click="open = !open" class="flex items-center">
            <i class="ph ph-faders text-lg"></i>
            <span class="ms-2 hidden md:block">Filtros Avanzados</span>
        </x-secondary-button>

        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-72 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-20 p-4" style="display: none;">
            {{-- ... contenido del dropdown de filtros ... --}}
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-4">
    <!-- Filtros rápidos visuales -->
    <div x-data="{ activeFilter: 'today' }" class="bg-white border border-sigedra-border rounded-lg p-2 flex items-center gap-x-1">
        <button @click="activeFilter = 'today'" :class="{'bg-sigedra-input text-sigedra-primary font-semibold': activeFilter === 'today', 'text-sigedra-text-medium hover:bg-sigedra-input/70': activeFilter !== 'today'}" class="px-3 py-1.5 text-sm rounded-md transition-colors">Hoy</button>
        <button @click="activeFilter = 'yesterday'" :class="{'bg-sigedra-input text-sigedra-primary font-semibold': activeFilter === 'yesterday', 'text-sigedra-text-medium hover:bg-sigedra-input/70': activeFilter !== 'yesterday'}" class="px-3 py-1.5 text-sm rounded-md transition-colors">Ayer</button>
        <button @click="activeFilter = '7days'" :class="{'bg-sigedra-input text-sigedra-primary font-semibold': activeFilter === '7days', 'text-sigedra-text-medium hover:bg-sigedra-input/70': activeFilter !== '7days'}" class="px-3 py-1.5 text-sm rounded-md transition-colors">Últimos 7 días</button>
        <button @click="activeFilter = '30days'" :class="{'bg-sigedra-input text-sigedra-primary font-semibold': activeFilter === '30days', 'text-sigedra-text-medium hover:bg-sigedra-input/70': activeFilter !== '30days'}" class="px-3 py-1.5 text-sm rounded-md transition-colors">Últimos 30 días</button>
    </div>

    <div class="bg-white border border-sigedra-border rounded-lg shadow-sm overflow-hidden">
        {{-- ----- INICIO DEL CAMBIO IMPORTANTE ----- --}}
        {{-- Se reemplaza <x-table> por la estructura de tabla directa para evitar el doble borde --}}
            <div class="flex flex-col">
                <div class="overflow-hidden">
                    <table class="min-w-full md:divide-y">
                        <thead class="bg-sigedra-input hidden md:table-header-group">
                        <tr>
                            <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Fecha y Hora</th>
                            <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Actividad</th>
                            <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-4 text-start text-sm font-semibold text-sigedra-text-medium uppercase tracking-wider">Detalles</th>
                        </tr>
                        </thead>
                        <tbody class="md:divide-y divide-sigedra-border">
                        @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-sigedra-text-medium">{{ $log['timestamp'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-x-3">
                                    <i class="ph {{ $log['icon'] }} text-lg {{ $log['color'] }}"></i>
                                    <span class="font-medium text-sigedra-text-dark">{{ $log['activity'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-x-2">
                                        <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-sigedra-input text-xs font-semibold text-sigedra-primary">
                                            {{ $log['user_avatar_initials'] }}
                                        </span>
                                    <span class="text-sm text-sigedra-text-medium">{{ $log['user'] }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-sigedra-text-medium">{{ $log['details'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-sigedra-text-medium">No hay registros de actividad disponibles.</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- ----- FIN DEL CAMBIO IMPORTANTE ----- --}}

            <!-- Paginación Corregida -->
            <div class="p-4 border-t border-sigedra-border flex items-center justify-between">
                <div class="text-sm text-sigedra-text-medium">
                    Mostrando <span class="font-semibold">1</span> a <span class="font-semibold">5</span> de <span class="font-semibold">25</span> resultados
                </div>
                <nav class="flex items-center space-x-2">
                    <button type="button" class="px-2.5 py-1.5 text-sm font-medium text-sigedra-text-light bg-white border border-sigedra-border rounded-md cursor-not-allowed">
                        Anterior
                    </button>
                    <button type="button" class="px-2.5 py-1.5 text-sm font-medium text-sigedra-text-dark bg-white border border-sigedra-border rounded-md hover:bg-sigedra-light-colored-bg">
                        Siguiente
                    </button>
                </nav>
            </div>
    </div>
</div>
@endsection
