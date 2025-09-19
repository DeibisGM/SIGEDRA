@props(['title', 'body', 'variant' => 'default'])

@php
$variants = [
'default' => 'bg-sigedra-card text-sigedra-text-dark border rounded-lg p-6',
'primary' => 'bg-sigedra-primary text-white rounded-lg p-6',
'secondary' => 'bg-sigedra-secondary text-white rounded-lg p-6',
'accent' => 'bg-sigedra-accent text-white rounded-lg p-6',
];
@endphp

<div {{ $attributes->merge(['class' => $variants[$variant] ?? $variants['default']]) }}>
    <h3 class="font-bold text-xl text-inherit mb-2">{{ $title }}</h3>
    <p class="text-3xl font-semibold">{{ $body }}</p>
</div>
