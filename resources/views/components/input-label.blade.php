@props(['value'])

{{--
Cambiamos 'text-gray-900' a 'text-gray-800' y 'font-medium' a 'font-semibold'
para mejorar la legibilidad en toda la aplicación.
--}}
<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-sigedra-text-dark dark:text-sigedra-text-light']) }}>
    {{ $value ?? $slot }}
</label>
