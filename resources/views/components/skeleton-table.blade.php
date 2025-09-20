<div class="w-full">
    <div class="animate-pulse">
        {{-- Skeleton Header --}}
        <div class="h-12 bg-gray-200 rounded-t-lg"></div>

        {{-- Skeleton Body --}}
        <div class="space-y-2 p-4">
            @for ($i = 0; $i < 5; $i++)
            <div class="h-10 bg-gray-200 rounded"></div>
            @endfor
        </div>
    </div>
</div>
