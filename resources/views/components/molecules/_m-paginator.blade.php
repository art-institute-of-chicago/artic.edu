@if (isset($paginator))
    @if ($paginator->hasPages())
        <nav class="m-paginator">
          <ul class="m-paginator__prev-next">
            <li>
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="f-buttons">
                    <span>Next</span>
                    <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                </a>
                @else
                    <span class="f-buttons">
                        <span>Next</span>
                        <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                    </span>
                @endif
            </li>
            <li>
                @if ($paginator->onFirstPage())
                    <span class="f-buttons">
                        <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                        <span>Previous</span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="f-buttons">
                        <span class="f-buttons">
                            <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                            <span>Previous</span>
                        </span>
                    </a>
                @endif
            </li>
          </ul>
          <ul class="m-paginator__pages">

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="f-buttons">&hellip;</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="s-active"><a href="{{ $url }}" class="f-buttons">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}" class="f-buttons">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
          </ul>
          <p class="m-paginator__current-page f-buttons">Page 1</p>
        </nav>
    @endif
@else
    <nav class="m-paginator">
      <ul class="m-paginator__prev-next">
        <li>
            <a href="#" class="f-buttons">
                <span>Next</span>
                <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
            </a>
        </li>
        <li>
            <span class="f-buttons">
                <svg aria-hidden="true" class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow"></use></svg>
                <span>Previous</span>
            </span>
        </li>
      </ul>
      <ul class="m-paginator__pages">
        <li class="s-active"><a href="#" class="f-buttons">1</a></li>
        <li><a href="#" class="f-buttons">2</a></li>
        <li><a href="#" class="f-buttons">3</a></li>
        <li><a href="#" class="f-buttons">4</a></li>
        <li><a href="#" class="f-buttons">5</a></li>
        <li><span class="f-buttons">&hellip;</span></li>
        <li><a href="#" class="f-buttons">99</a></li>
      </ul>
      <p class="m-paginator__current-page f-buttons">Page 1</p>
    </nav>
@endif

