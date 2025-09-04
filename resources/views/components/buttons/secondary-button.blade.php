@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center text-sm font-medium rounded-lg border border-sigedra-border bg-white text-sigedra-text-dark hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors'
    ]) }}>
    {{ $slot }}
</button>
