@props(['value'])

{{--
Cambiamos 'text-gray-900' a 'text-gray-800' y 'font-medium' a 'font-semibold'
para mejorar la legibilidad en toda la aplicación.
--}}
<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-800 dark:text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
