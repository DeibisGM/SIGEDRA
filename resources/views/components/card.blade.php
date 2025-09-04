@props(['title', 'body', 'variant' => 'default'])

@php
$variants = [
    'default' => 'bg-white dark:bg-neutral-800 text-gray-900 dark:text-white shadow-md rounded-md p-4',
    'primary' => 'bg-primary text-white shadow-lg rounded-md p-4',
    'success' => 'bg-success text-white shadow-lg rounded-md p-4',
];
@endphp

<div {{ $attributes->merge(['class' => $variants[$variant] ?? $variants['default']]) }}>
    <h3 class="font-bold text-lg mb-2">{{ $title }}</h3>
    <p>{{ $body }}</p>
</div>
