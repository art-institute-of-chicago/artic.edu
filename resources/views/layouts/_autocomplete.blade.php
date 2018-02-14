@if ( !empty( $items ) )
    <div class="g-search__autocomplete">
        <ul>
            @foreach ($items as $item)
                <li>
                    <a href="{{ $item['url'] }}">
                        @component('components.atoms._img')
                            @slot('src', $item['image']['src'])
                            @slot('width', $item['image']['width'])
                            @slot('height', $item['image']['height'])
                        @endcomponent

                        {{ $item['text'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <a href="{{ isset($seeAllUrl) ? $seeAllUrl : route('search') }}" class="g-search__autocomplete-all">See {{ $resultCount }} {{ $resultCount == 1 ? 'result' : 'results' }} for {{ $term }} &rsaquo;</a>
    </div>
@endif
