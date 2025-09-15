@props(['type' => 'button', 'href' => null])

@if ($href)
<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-primary text-white hover:bg-opacity-90 focus:outline-none focus:bg-sigedra-primary-dark transition-all shadow-sm'
    ]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-primary text-white hover:bg-opacity-90 focus:outline-none focus:bg-sigedra-primary-dark transition-all shadow-sm'
    ]) }}>
    {{ $slot }}
</button>
@endif
