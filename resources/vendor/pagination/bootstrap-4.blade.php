@if ($paginator->hasPages())
    <div class="pagination-section" style="display: flex;justify-content: center;">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="paginate_button page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <a class="page-link"  href="javascript:void(0)" aria-hidden="true">&lsaquo;</a>
                </li>
            @else
                <li class="paginate_button page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="paginate_button page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="paginate_button page-item active" aria-current="page"><a class="page-link" href="javascript:void(0)">{{ $page }}</a></li>
                        @else
                            <li class="paginate_button page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginate_button page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="paginate_button page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <a class="page-link" href="javascript:void(0)" aria-hidden="true">&rsaquo;</a>
                </li>
            @endif
        </ul>
    </div>
@endif
