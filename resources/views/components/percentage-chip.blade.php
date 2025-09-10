@props(['percentage'])

@php
    $baseClasses = 'text-sm font-bold w-16 inline-flex items-center justify-center me-2 px-2.5 py-0.5 rounded-full border';
    $colorClasses = '';
    if ($percentage < 70) {
        $colorClasses = 'bg-sigedra-error/10 text-sigedra-error border-sigedra-error';
    } elseif ($percentage >= 70 && $percentage <= 80) {
        $colorClasses = 'bg-sigedra-warning/10 text-sigedra-warning border-sigedra-warning';
    } else {
        $colorClasses = 'bg-sigedra-light-colored-bg text-sigedra-secondary border-sigedra-secondary';
    }
@endphp

<span class="{{ $baseClasses }} {{ $colorClasses }}">
    {{ $percentage }}%
</span>