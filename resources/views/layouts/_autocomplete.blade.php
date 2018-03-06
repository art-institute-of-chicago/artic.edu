@if ( !empty( $items ) )
    <div class="g-search__autocomplete" data-autocomplete-list>
        <ul>
            @foreach ($items as $item)
                <li>
                    <a href="{{ $item->url }}">
                        @if ($item->image)
                            @component('components.atoms._img')
                                @slot('image', $item->image)
                                @slot('settings', array(
                                    'srcset' => array(40,80),
                                    'sizes' => '40px',
                                ))
                            @endcomponent
                        @endif
                        <strong>{{ str_limit($item->text, 100) }}</strong>
                        @unless(empty($item->section))
                            in
                            <strong>{{ $item->section }}</strong>
                        @endunless
                    </a>
                </li>
            @endforeach
        </ul>
        <p class="g-search__autocomplete-all f-buttons">
            <a href="{{ isset($seeAllUrl) ? $seeAllUrl : route('search') }}">See {{ $resultCount }} {{ $resultCount == 1 ? 'result' : 'results' }} for {{ $term }}&nbsp;&nbsp;&rsaquo;</a>
        </p>
    </div>
@endif
