<!-- resources/views/components/skeletons/maestros-table-skeleton.blade.php -->

<div>
    <!-- Skeleton Desktop -->
    <div class="hidden md:block">
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                <div class="flex items-center gap-x-4">
                    <div class="h-6 bg-gray-300 rounded animate-pulse w-[250px]"></div>
                </div>
            </div>
            <div class="divide-y divide-gray-200">
                @for ($i = 0; $i < 5; $i++)
                <div class="px-6 py-3 animate-pulse">
                    <div class="flex items-center gap-x-4">
                        <div class="h-[38px] bg-gray-200 rounded w-[15%]"></div>
                        <div class="h-[38px] bg-gray-200 rounded w-[25%]"></div>
                        <div class="h-[38px] bg-gray-200 rounded w-[15%]"></div>
                        <div class="h-[38px] bg-gray-200 rounded w-[25%]"></div>
                        <div class="flex items-center justify-center gap-x-2" style="width: 20%;">
                            <div class="h-[38px] w-[38px] bg-gray-200 rounded"></div>
                            <div class="h-[38px] w-[38px] bg-gray-200 rounded"></div>
                            <div class="h-[38px] w-[38px] bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Skeleton Mobile -->
    <div class="block md:hidden space-y-2">
        @for ($i = 0; $i < 5; $i++)
        <div class="bg-white border rounded-lg p-4 animate-pulse">
            <div class="flex justify-between items-start">
                <div class="space-y-2">
                    <div class="h-5 w-32 bg-gray-200 rounded"></div>
                    <div class="h-4 w-24 bg-gray-200 rounded"></div>
                </div>
            </div>
            <div class="mt-4 space-y-2">
                <div class="h-4 w-48 bg-gray-200 rounded"></div>
                <div class="h-4 w-40 bg-gray-200 rounded"></div>
            </div>
            <div class="mt-4 border-t pt-4 flex justify-end items-center">
                <div class="flex space-x-2">
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                    <div class="h-8 w-8 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>
