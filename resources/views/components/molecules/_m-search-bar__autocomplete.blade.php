@if ( !empty( $items ) )
    <ul class="m-search-bar__autocomplete f-secondary" data-autocomplete-list>
        @foreach ($items as $item)
            <li><a href="{{ $item['href'] }}">{{ $item['label'] }}</a></li>
        @endforeach
    </ul>
@endif
