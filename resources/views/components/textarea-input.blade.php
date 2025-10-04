@props([
    'disabled' => false,
])

<textarea x-data="{
        resize() {
            const el = $el;
            el.style.height = 'auto';
            el.style.height = `${el.scrollHeight}px`;
            el.style.overflowY = 'hidden';
        }
    }"
    x-init="$nextTick(() => resize())"
    @input="resize()"
    {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 placeholder-gray-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md']) !!}></textarea>
