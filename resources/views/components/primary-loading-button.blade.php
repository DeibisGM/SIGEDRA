@props([
    'type' => 'submit',
    'loading' => false,
    'wireTarget' => null,
])

@php
$baseClasses = 'py-2 px-4 inline-flex items-center justify-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-sigedra-primary text-white hover:bg-sigedra-primary-dark focus:outline-none focus:bg-sigedra-primary-dark transition-all shadow-sm relative';
@endphp

<button {{ $attributes->except('wire:target')->merge(['type' => $type, 'class' => $baseClasses]) }}
    @if(!$wireTarget) x-bind:disabled="{{ $loading }}" @endif
>
    @if($wireTarget)
        <span wire:loading.remove wire:target="{{ $wireTarget }}" class="flex items-center gap-x-2">
            {{ $slot }}
        </span>
        <span wire:loading wire:target="{{ $wireTarget }}">
            <div class="animate-spin-custom flex items-center justify-center">
                <i class="ph-bold ph-spinner text-xl"></i>
            </div>
        </span>
    @else
        <span class="flex items-center gap-x-2" :class="{ 'invisible': {{ $loading }} }">
            {{ $slot }}
        </span>
        <span x-show="{{ $loading }}" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" style="display: none;">
            <div class="animate-spin-custom flex items-center justify-center">
                <i class="ph-bold ph-spinner text-xl"></i>
            </div>
        </span>
    @endif
</button>
