{{-- resources/views/components/card-header.blade.php --}}
<h1 class="text-xl font-bold text-gray-800 leading-tight flex items-center justify-between pt-4 my-4">
    <span>{{ $title }}</span>

    <div class="flex-shrink-0 flex gap-3">
        {{ $slot }}
    </div>
</h1>
