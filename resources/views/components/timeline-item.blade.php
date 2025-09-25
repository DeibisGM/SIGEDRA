@props(['timestamp', 'icon', 'color', 'title', 'user', 'details'])

@php
$colors = [
'blue' => 'bg-blue-500',
'gray' => 'bg-gray-400',
'purple' => 'bg-purple-500',
'orange' => 'bg-orange-500',
'green' => 'bg-green-500',
'red' => 'bg-red-500',
];
$bgColorClass = $colors[$color] ?? 'bg-gray-500';
@endphp

<div class="relative flex gap-x-4">
    <!-- Línea vertical de la timeline -->
    <div class="absolute left-4 top-4 h-full w-0.5 bg-gray-200 -z-10"></div>

    <!-- Icono -->
    <div class="flex-shrink-0 h-8 w-8 mt-2.5 flex items-center justify-center rounded-full {{ $bgColorClass }} text-white">
        <i class="ph {{ $icon }} text-lg"></i>
    </div>

    <!-- Contenido del evento -->
    <div class="flex-grow py-3 pe-4">
        <p class="text-xs text-sigedra-text-medium">{{ $timestamp }}</p>
        <h3 class="text-base font-semibold text-sigedra-text-dark">{{ $title }}</h3>

        <div class="mt-1 flex items-center gap-x-3 text-sm text-sigedra-text-medium">
            @if($user)
            <div class="flex items-center gap-x-1.5">
                <i class="ph ph-user-circle text-base"></i>
                <span>{{ $user }}</span>
            </div>
            @endif
            <div class="flex items-center gap-x-1.5">
                <i class="ph {{ $user ? 'ph-tag' : 'ph-clock' }} text-base"></i>
                <span>{{ $details }}</span>
            </div>
        </div>
    </div>
</div>
