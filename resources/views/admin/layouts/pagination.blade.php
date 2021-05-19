@if($paginator->hasPages())
<div class="clearfix">
    <div class="hint-text">Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of total {{$paginator->total()}} entries</div>
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if($paginator->onFirstPage())
            <li class="page-item disabled"><a href="javascript:void(0)" class="page-link">Previous</a></li>
        @else
            <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}">Previous</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><a class="page-link">{{$element}}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <li class="page-item active"><a href="{{$url}}" class="page-link">{{$page}}</a></li>
                    @else
                        <li class="page-item"><a href="{{$url}}" class="page-link">{{$page}}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next</a></li>
        @else
            <li class="page-item disabled"><a href="javascript:void(0)" class="page-link">Next</a></li>
        @endif
    </ul>
</div>
@endif
