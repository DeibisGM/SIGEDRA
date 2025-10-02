@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-sigedra-border placeholder-gray-400 focus:border-sigedra-text-dark rounded-md']) }}>
