@props(['type' => 'button'])

<button {{ $attributes->merge([
    'type' => $type,
    'class' => 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-medium rounded-lg border bg-white text-sigedra-text-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors shadow-sm'
    ]) }}>
    {{ $slot }}
</button>
