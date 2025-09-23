@for ($i = 0; $i < 5; $i++)
    <tr {{ $attributes->merge(['wire:key' => "skeleton-{$i}", 'class' => 'bg-white animate-pulse']) }}>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-3/4"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-full"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-full"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-full"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto"></div>
        </td>
        <td class="px-6 py-3">
            <div class="h-4 bg-gray-200 rounded w-1/4 mx-auto"></div>
        </td>
        <td class="px-6 py-3">
            <div class="w-full flex items-center justify-center gap-x-2">
                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
            </div>
        </td>
    </tr>
@endfor
