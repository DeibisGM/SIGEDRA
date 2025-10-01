@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-sigedra-text-dark py-2']) }}>
    {{ $value ?? $slot }}
</label>
