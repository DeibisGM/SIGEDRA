@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex flex-col items-center space-y-4">
        {{-- Pagination Links --}}
        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-sigedra-border cursor-default rounded-l-md leading-5" aria-hidden="true">
                            <i class="ph ph-caret-left"></i>
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-sigedra-text-medium bg-white border border-sigedra-border rounded-l-md leading-5 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigedra-primary-200 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                        <i class="ph ph-caret-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-sigedra-border cursor-default leading-5">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-white bg-sigedra-primary border border-sigedra-primary cursor-default leading-5">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-sigedra-text-medium bg-white border border-sigedra-border leading-5 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigedra-primary-200 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-sigedra-text-medium bg-white border border-sigedra-border rounded-r-md leading-5 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigedra-primary-200 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                        <i class="ph ph-caret-right"></i>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-400 bg-white border border-sigedra-border cursor-default rounded-r-md leading-5" aria-hidden="true">
                            <i class="ph ph-caret-right"></i>
                        </span>
                    </span>
                @endif
            </span>
        </div>

        {{-- Results Counter --}}
        <div class="hidden sm:flex">
            <p class="text-sm text-sigedra-text-medium leading-5">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span class="font-semibold text-sigedra-text-strong">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-semibold text-sigedra-text-strong">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-semibold text-sigedra-text-strong">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>
    </nav>
@endif