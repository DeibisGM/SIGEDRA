{{-- resources/views/components/filter-button.blade.php --}}
<button {{ $attributes->merge([
    'type' => 'button',
    'class' => 'relative mt-1 w-full h-11 text-left bg-white border rounded-lg ps-3 pe-10 p-2.5 focus:border-sigedra-text-medium sm:text-sm flex items-center'
    ]) }}>
    <span class="block truncate flex-grow">{{ $slot }}</span>
    <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
        <i class="ph ph-caret-down text-lg text-sigedra-text-light"></i>
    </span>
</button>
