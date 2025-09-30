@props(['type' => 'button', 'href' => null])

@if ($href)
<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-md border bg-sigedra-components-bg text-sigedra-text-medium hover:bg-sigedra-medium-bg focus:outline-none focus:bg-sigedra-medium-bg transition-colors'
    ]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-md border bg-sigedra-components-bg text-sigedra-text-medium hover:bg-sigedra-medium-bg focus:outline-none focus:bg-sigedra-medium-bg transition-colors'
    ]) }}>
    {{ $slot }}
</button>
@endif
