@props(['type', 'message'])

@php
$colorClasses = match ($type) {
'success' => 'bg-green-100 border-green-400 text-green-700',
'error' => 'bg-red-100 border-red-400 text-red-700',
default => 'bg-gray-100 border-gray-400 text-gray-700', // Un color por defecto
};
$title = match ($type) {
'success' => '¡Éxito!',
'error' => '¡Error del Sistema!',
default => 'Atención',
};
@endphp

<div id="flash-alert"
     class="{{ $colorClasses }} px-4 py-3 rounded relative mb-4 transition-opacity duration-300"
     role="alert">
    <strong class="font-bold">{{ $title }}</strong>
    <span class="block sm:inline ml-2">{{ $message }}</span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('flash-alert');
        if (alert) {

            setTimeout(() => {

                alert.style.opacity = '0';

                setTimeout(() => {
                    alert.remove();
                }, 300);

            }, 3000);
        }
    });
</script>
