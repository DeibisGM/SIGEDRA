@props(['nombre', 'materia', 'nota'])

<div class="p-4 shadow-md rounded-md bg-white dark:bg-neutral-800 hover:bg-gray-100 dark:hover:bg-neutral-700">
    <h2 class="text-lg font-bold">{{ $nombre }}</h2>
    <p>{{ $materia }} - Nota: {{ $nota }}</p>
</div>
