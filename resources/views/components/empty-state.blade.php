@props([
    'message' => 'No se encontraron registros.',
])

<tr>
    <td colspan="100%" class="px-6 py-8 text-center text-base text-gray-500">
        {{ $message }}
    </td>
</tr>
