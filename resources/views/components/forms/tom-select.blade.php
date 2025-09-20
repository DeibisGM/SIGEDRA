@props(['options', 'wireModel', 'placeholder' => 'Seleccione una opción'])

<div wire:ignore>
    <select
        x-data="tomSelect({
            wireModel: '{{ $wireModel }}',
            settings: {
                options: {{ json_encode($options) }},
                placeholder: '{{ $placeholder }}',
                valueField: 'id',
                labelField: 'text',
                searchField: 'text',
                create: false,
                onChange: (value) => {
                    $wire.set('{{ $wireModel }}', value);
                }
            }
        })"
        {{ $attributes }}
    >
    </select>
</div>
