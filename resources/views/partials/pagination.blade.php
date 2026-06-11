{{-- partials/pagination.blade.php --}}
{{-- Accepts: $paginator (LengthAwarePaginator) --}}

@if(!empty($paginator) && $paginator->lastPage() > 1)
<div class="pagination56-wrapper">
    <div class="pagination56">
        {{-- Previous --}}
        @if(!$paginator->onFirstPage())
        <a class="page-numbers prev" href="{{ $paginator->previousPageUrl() }}">
            <span>&laquo; Prev</span>
        </a>
        @endif

        {{-- Page numbers --}}
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
        @endphp

        @for($i = 1; $i <= $lastPage; $i++)
            @if($i === $currentPage)
                <span class="page-numbers current" aria-current="page"><span>{{ $i }}</span></span>
            @elseif($i <= 2 || $i >= $lastPage - 1 || abs($i - $currentPage) <= 1)
                <a class="page-numbers" href="{{ $paginator->url($i) }}"><span>{{ $i }}</span></a>
            @elseif(abs($i - $currentPage) === 2)
                <span class="page-numbers dots">&hellip;</span>
            @endif
        @endfor

        {{-- Next --}}
        @if($paginator->hasMorePages())
        <a class="page-numbers next" href="{{ $paginator->nextPageUrl() }}">
            <span>Next &raquo;</span>
        </a>
        @endif
    </div>
</div>
@endif
