@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center justify-center text-sm font-semibold rounded-lg border border-transparent bg-sigedra-primary text-white hover:bg-sigedra-primary/90 focus:outline-none focus:ring-2 focus:ring-sigedra-primary focus:ring-offset-2 transition-all'
    ]) }}>
    {{ $slot }}
</button>
