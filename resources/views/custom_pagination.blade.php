<!-- resources/views/custom_pagination.blade.php -->

<ul class="pagination">
    {{-- Decremental Button --}}
    @if ($paginator->onFirstPage())
        <li class="pagination-btn disabled"><span>&laquo;</span></li>
    @else
        <li class="pagination-btn"><a class="mypagination-inc-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
    @endif

    
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
    {{-- "Three Dots" Separator --}}
    @if (is_string($element))
    <li class="pagination-btn disabled"><span>{{ $element }}</span></li>
    @endif
    
    {{-- Array of links --}}
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <li class="pagination-btn active"><span>{{ $page }}</span></li>
    @else
    <li class="pagination-btn"><a href="{{ $url }}">{{ $page }}</a></li>
    @endif
    @endforeach
    @endif
    @endforeach

    {{-- Incremental Button --}}
    @if ($paginator->hasMorePages())
        <li class="pagination-btn"><a class="mypagination-inc-btn" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
    @else
        <li class="pagination-btn disabled"><span>&raquo;</span></li>
    @endif


</ul>
