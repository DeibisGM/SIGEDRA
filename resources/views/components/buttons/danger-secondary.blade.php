@props(['type' => 'button', 'href' => null])

@if ($href)
    <a {{ $attributes->merge([
        'href' => $href,
        'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-medium rounded-lg border bg-white text-sigedra-error hover:bg-sigedra-error hover:text-white focus:outline-none focus:ring-2 focus:ring-sigedra-error focus:ring-offset-2 transition-colors shadow-sm'
        ]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge([
        'type' => $type,
        'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-medium rounded-lg border bg-white text-sigedra-error hover:bg-sigedra-error hover:text-white focus:outline-none focus:ring-2 focus:ring-sigedra-error focus:ring-offset-2 transition-colors shadow-sm'
        ]) }}>
        {{ $slot }}
    </button>
@endif
