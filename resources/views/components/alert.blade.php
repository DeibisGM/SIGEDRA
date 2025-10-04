@props([
    'type' => 'info',
])

@php
    $baseClasses = 'border px-4 py-3 rounded relative flex items-center gap-x-2';
    $typeClasses = match ($type) {
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error' => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
        default => 'bg-blue-100 border-blue-400 text-blue-700',
    };
    $icon = match ($type) {
        'success' => 'check-circle',
        'error' => 'x-circle',
        'warning' => 'warning',
        default => 'warning-circle',
    };
@endphp

<div class="{{ $baseClasses }} {{ $typeClasses }} mb-4" role="alert">
    <i class="ph-fill ph-{{ $icon }} text-xl"></i>
    <span class="block sm:inline">{{ $slot }}</span>
</div>
