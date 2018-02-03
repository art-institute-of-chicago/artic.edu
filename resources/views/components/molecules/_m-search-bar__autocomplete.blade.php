@if ( !empty( $items ) )
    <div class="m-search-bar__autocomplete dropdown">
        <ul>
            @foreach ($items as $item)
                <li><a href="#">{{ $item }}</a></li>
            @endforeach
        </ul>

        <a href="#" class="m-search-bar__autocomplete-close" data-autocomplete-close>
            <svg aria-label="Clear search" class="icon--close"><use xlink:href="#icon--close" /></svg>
        </a>
    </div>
@endif
