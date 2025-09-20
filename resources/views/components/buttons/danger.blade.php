@props(['type' => 'button', 'href' => null])

@php
// Se definen las clases CSS para el botón de peligro, usando los colores de tu tailwind.config.js
$classes = 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-error text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all shadow-sm';
@endphp

@if ($href)
{{-- Si el botón es un enlace (tiene un 'href'), se renderiza como una etiqueta <a> --}}
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        {{ $slot }}
    </a>
    @else
    {{-- De lo contrario, se renderiza como una etiqueta <button> --}}
        <button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
            {{ $slot }}
        </button>
        @endif
