@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-sigedra-primary dark:border-sigedra-primary-dark text-start text-base font-medium text-sigedra-primary dark:text-sigedra-light-colored-bg bg-sigedra-light-colored-bg dark:bg-sigedra-primary-dark focus:outline-none focus:text-sigedra-primary-dark dark:focus:text-sigedra-light-colored-bg focus:bg-sigedra-light-colored-bg dark:focus:bg-sigedra-primary-dark focus:border-sigedra-primary-dark dark:focus:border-sigedra-light-colored-bg transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-sigedra-text-medium dark:text-sigedra-text-light hover:text-sigedra-text-dark dark:hover:text-sigedra-text-medium hover:bg-sigedra-light-colored-bg dark:hover:bg-sigedra-primary-dark hover:border-sigedra-border dark:hover:border-sigedra-border focus:outline-none focus:text-sigedra-text-dark dark:focus:text-sigedra-text-medium focus:bg-sigedra-light-colored-bg dark:focus:bg-sigedra-primary-dark focus:border-sigedra-border dark:focus:border-sigedra-border transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
