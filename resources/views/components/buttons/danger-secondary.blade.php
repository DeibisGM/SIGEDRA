@props(['type' => 'button', 'href' => null])

@if ($href)
<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-base font-medium rounded-md border bg-white text-sigedra-error hover:bg-sigedra-error hover:text-white focus:outline-none focus:bg-sigedra-error-light focus:text-white transition-colors'
    ]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-3 inline-flex items-center justify-center gap-x-2 text-base font-medium rounded-md border bg-white text-sigedra-error hover:bg-sigedra-error hover:text-white focus:outline-none focus:bg-sigedra-error-light focus:text-white transition-colors'
    ]) }}>
    {{ $slot }}
</button>
@endif
