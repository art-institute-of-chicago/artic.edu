

@if (isset($item['titleLink']) and $item['titleLink'] and isset($item['image']) and !empty($item['image']))
    <{{ $tag or 'li' }} class="m-listing m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}">
        <a href="{{ $item['titleLink'] }}" class="m-listing__link">
@else
    <{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
@endif

        @if ( isset($item['image']) and !empty($item['image']) )
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                @component('components.atoms._img')
                    @slot('image', $item['image'])
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            </span>
        @endif

    @if (isset($item['titleLink']) and $item['titleLink'] and isset($item['image']) and !empty($item['image']))
        </a>
    @endif

    <span class="m-listing__meta">
        @if (isset($item['title']) and $item['title'])
            @if (isset($item['titleLink']) and $item['titleLink'])
                @component('components.atoms._title')
                    @slot('variation', 'title--w-right-arrow')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('tag', 'a')
                    @slot('href', $item['titleLink'])
                    {{ $item['title'] }} <span class='title__arrow'>&rsaquo;</span>
                @endcomponent
            @else
                @component('components.atoms._title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    {{ $item['title'] }}
                @endcomponent
            @endif
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

                    {{-- MIKE: PLEASE integrate this --}}
                    @if (isset($link['external']))
                        @slot('external', $link['external'])
                    @endif
                @endcomponent
                </li>
            @endforeach
            </ul>
        @endif
    </span>

</{{ $tag or 'li' }}>
