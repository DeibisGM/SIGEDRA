@props([
    'icon' => null,
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-x-1.5 bg-sigedra-medium-bg text-sigedra-text-dark text-sm font-medium px-2.5 py-1 rounded-md border']) }}>
    @if($icon)
        <i class="ph ph-{{ $icon }} text-base"></i>
    @endif
    {{ $slot }}
</span>
