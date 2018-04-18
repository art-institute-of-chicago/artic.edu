

@if (isset($item['titleLink']) and $item['titleLink'])
    <{{ $tag or 'li' }} class="m-listing m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}">
        <a href="{{ $item['titleLink'] }}" class="m-listing__link">
@else
    <{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
@endif

        @if ( isset ($item['image']) && !empty( $item['image'] ) )
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                @component('components.atoms._img')
                    @slot('image', $item['image'])
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            </span>
        @endif

    @if (isset($item['titleLink']) and $item['titleLink'])

        @if (isset($item['title']) and $item['title'])
            <span class="m-listing__meta">
                @component('components.atoms._title')
                    @slot('variation', 'title--w-right-arrow')
                    @slot('font', $titleFont ?? 'f-list-3')
                    {{ $item['title'] }} <span class='title__arrow'>&rsaquo;</span>
                @endcomponent
            </span>
        @endif

        </a>
    @endif

    <span class="m-listing__meta">
        @if (empty($item['titleLink']))
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item['title'] }}
            @endcomponent
            <br>
        @endif
        @if (isset($item['text']) and $item['text'])
            @component('components.blocks._text')
                @slot('font', 'f-secondary')
                @slot('tag', 'span')
                {!! $item['text'] !!}
            @endcomponent
        @endif
        @if (isset($item['links']) and $item['links'])
            <br>
            <ul>
            @foreach ($item['links'] as $link)
                <li>
                @component('components.atoms._arrow-link')
                    @slot('href', $link['href'])
                    {!! $link['label'] !!}
                @endcomponent
                </li>
            @endforeach
            </ul>
        @endif
    </span>

</{{ $tag or 'li' }}>
