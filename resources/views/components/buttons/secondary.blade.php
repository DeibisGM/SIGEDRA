@props(['type' => 'button', 'href' => null])

@if ($href)
<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border bg-white text-sigedra-text-medium hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition-colors shadow-sm'
    ]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border bg-white text-sigedra-text-medium hover:bg-gray-50 focus:outline-none focus:bg-gray-100 transition-colors shadow-sm'
    ]) }}>
    {{ $slot }}
</button>
@endif
