@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-sigedra-border focus:border-sigedra-text-dark rounded-md']) }}>
