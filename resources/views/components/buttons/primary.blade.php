@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-accent text-white hover:bg-sigedra-accent/90 focus:outline-none focus:ring-2 focus:ring-sigedra-accent focus:ring-offset-2 transition-all'
    ]) }}>
    {{ $slot }}
</button>
