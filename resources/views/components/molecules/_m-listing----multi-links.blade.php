<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">

    @if ( !empty( $item['image'] ) )
        <span class="m-listing__img m-listing__img--wide">
            @component('components.atoms._img')
                @slot('src', $item['image']['src'])
                @slot('width', $item['image']['width'])
                @slot('height', $item['image']['height'])
            @endcomponent
        </span>
    @endif

    <span class="m-listing__meta">
        @if (isset($item['title']) and $item['title'])
            @if (isset($item['titleLink']) and $item['titleLink'])
                @component('components.atoms._arrow-link')
                    @slot('variation', 'title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('href', $item['titleLink'])
                    {{ $item['title'] }}
                @endcomponent
            @else
                @component('components.atoms._title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    {{ $item['title'] }}
                @endcomponent
            @endif
        @endif
        @if (isset($item['text']) and $item['text'])
            <br>
            @component('components.blocks._text')
                @slot('font', 'f-secondary')
                @slot('tag', 'span')
                {{ $item['text'] }}
            @endcomponent
        @endif
        @if (isset($item['links']) and $item['links'])
            <br>
            @foreach ($item['links'] as $link)
                @component('components.atoms._arrow-link')
                    @slot($link['href'], '#')
                    {{ $link['label'] }}
                @endcomponent
            @endforeach
        @endif
    </span>

</{{ $tag or 'li' }}>
