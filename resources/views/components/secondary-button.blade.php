@props(['type' => 'button', 'href' => null])

@php
$baseClasses = 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-md border bg-sigedra-components-bg text-sigedra-text-medium hover:bg-sigedra-components-hover-bg focus:outline-none focus:sigedra-components-hover-bg transition-colors';
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
