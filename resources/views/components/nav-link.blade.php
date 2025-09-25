@props(['href', 'active' => false])

@php
$classes = 'flex items-center gap-x-3.5 py-2 px-2.5 text-base rounded-lg transition-colors duration-200 ';
$classes .= $active
? 'bg-sigedra-input text-sigedra-secondary font-semibold'
: 'text-sigedra-text-medium hover:bg-sigedra-input/70';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
