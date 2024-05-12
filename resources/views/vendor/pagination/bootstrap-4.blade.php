@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            {{-- Always show first page --}}
            <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>

            {{-- Show ellipsis if current page - 2 is greater than or equal to 4 --}}
            @if ($paginator->currentPage() - 2 >= 4)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif

            {{-- Show page numbers within current page - 2 to current page + 2 range --}}
            @for ($i = max(2, $paginator->currentPage() - 2); $i <= min($paginator->lastPage(), $paginator->currentPage() + 2); $i++)
                @if ($i !== 1 && $i !== $paginator->lastPage())
                    {{-- Avoid repeating first and last page --}}
                    <li class="page-item @if ($i === $paginator->currentPage()) active @endif" aria-current="page">
                        <a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- Show page 2 if current page - 2 is 3 --}}
            @if ($paginator->currentPage() - 2 === 3)
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(2) }}">2</a></li>
            @endif

            {{-- Show ellipsis if current page + 2 is less than or equal to last page - 3 --}}
            @if ($paginator->currentPage() + 2 < $paginator->lastPage() - 3)
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
            @endif

            {{-- Show last page if current page + 2 is last page - 2 --}}
            @if ($paginator->currentPage() + 2 === $paginator->lastPage() - 2)
                <li class="page-item"><a class="page-link"
                        href="{{ $paginator->url($paginator->lastPage() - 1) }}">{{ $paginator->lastPage() - 1 }}</a>
                </li>
            @endif

            {{-- Always show last page --}}
            <li class="page-item"><a class="page-link"
                    href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
