@props(['type' => 'submit', 'href' => null])

@if ($href)
<a {{ $attributes->merge([
    'href' => $href,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-bg text-sigedra-text-dark hover:bg-red-600 hover:text-white focus:outline-none focus:bg-red-700 focus:text-white transition-all shadow-sm'
    ]) }}>
    {{ $slot }}
</a>
@else
<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-bg text-sigedra-text-dark hover:bg-red-600 hover:text-white focus:outline-none focus:bg-red-700 focus:text-white transition-all shadow-sm'
    ]) }}>
    {{ $slot }}
</button>
@endif
