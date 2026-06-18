@if ($paginator->hasPages())
<nav class="galeri-paging" aria-label="Navigasi halaman">
    <span class="galeri-paging-info">
        Menampilkan <strong>{{ $paginator->firstItem() }}</strong>&ndash;<strong>{{ $paginator->lastItem() }}</strong>
        dari <strong>{{ $paginator->total() }}</strong> foto
    </span>

    <div class="galeri-paging-btns">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="galeri-paging-btn is-disabled" aria-disabled="true">
                <i class="fa-solid fa-chevron-left"></i>
            </span>
        @else
            <a class="galeri-paging-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Halaman sebelumnya">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="galeri-paging-btn is-dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="galeri-paging-btn is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="galeri-paging-btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a class="galeri-paging-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Halaman berikutnya">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span class="galeri-paging-btn is-disabled" aria-disabled="true">
                <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </div>
</nav>
@endif
