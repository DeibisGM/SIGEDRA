@props(['type' => 'submit', 'href' => null])

@php
$baseClasses = 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border bg-sigedra-components-bg text-sigedra-text-dark hover:bg-red-600 hover:text-white focus:outline-none focus:bg-red-600 focus:text-white transition-all';
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
