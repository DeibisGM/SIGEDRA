@props(['label', 'value'])

<div {{ $attributes }}>
    <dt class="text-sm font-semibold text-sigedra-text-medium">{{ $label }}</dt>
    <dd class="mt-1 text-base text-sigedra-text-dark">{{ $value ?? $slot }}</dd>
</div>
