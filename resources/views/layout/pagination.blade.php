<style>
    .pagination {
        margin: 0px !important;
    }
</style>

@if($paginator->hasPages())
<ul class="pagination">
    <!-- Previous Page Link -->
    @if($paginator->onFirstPage())
        <li class="page-item disables">
            <a class="page-link"><span>Previous</span></a>
        </li>
    @else
        <li class="page-item">
            <a href="{{ $paginator->previousPageUrl() }}" class="page-link">Previous</a>
        </li>
    @endif

    <!-- Pagination Elements Here -->
    @foreach($elements as $element)
        <!-- Make Three Dots -->
        @if(is_string($element))
            <li class="page-item disabled">
                <a class="page-link"><span>{{ $element }}</span></a>
            </li>
        @endif

        <!-- Links Array Here -->
        @if(is_array($element))
            @foreach ($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <li class="page-item active">
                        <a href="{{ $url }}" class="page-link"><span>{{ $page }}</span></a>
                    </li>
                @else
                    <li class="page-item">
                        <a href="{{ $url }}" class="page-link"><span>{{ $page }}</span></a>
                    </li>
                @endif
            @endforeach
        @endif
    @endforeach

    <!-- Next Page Link -->
    @if($paginator->hasMorePages())
        <li class="page-item">
            <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><span>Next</span></a>
        </li>
    @else
        <li class="page-item disabled">
            <a class="page-link"><span>Next</span></a>
        </li>
    @endif
</ul>
@endif