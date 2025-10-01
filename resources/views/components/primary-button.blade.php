@props(['type' => 'submit', 'href' => null])

@php
$baseClasses = 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-primary text-white hover:bg-sigedra-primary-dark focus:outline-none focus:bg-sigedra-primary-dark transition-all shadow-sm';
@endphp

@if ($href)
<a {{ $attributes->merge(['href' => $href, 'class' => $baseClasses]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge(['type' => $type, 'class' => $baseClasses]) }}>
    {{ $slot }}
</button>
@endif
