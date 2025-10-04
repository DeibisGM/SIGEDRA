@props([
    'disabled' => false,
])

<textarea
    x-data="{
        resize() {
            const el = $el;
            el.style.height = 'auto';
            el.style.height = `${el.scrollHeight}px`;
            el.style.overflowY = 'hidden';
        }
    }"
    x-init="$nextTick(() => resize())"
    @input="resize()"
    {{ $disabled ? 'disabled' : '' }}
{!! $attributes->merge(['class' => 'block py-2 border-gray-300 placeholder-gray-400 focus:border-sigedra-text-dark focus:border-2 focus:border-gray-600 rounded-md']) !!}
></textarea>
