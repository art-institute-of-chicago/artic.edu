

@if (isset($item['titleLink']) and $item['titleLink'] and isset($item['image']) and !empty($item['image']))
    <{{ $tag or 'li' }} class="m-listing m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}">
        <h3 class="sr-only" id="h-{{ str_slug($item['title']) }}">{{ $item['title'] }}</h3>
        <a href="{!! $item['titleLink'] !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
@else
    <{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
        <h3 class="sr-only" id="h-{{ str_slug($item['title']) }}">{{ $item['title'] }}</h3>
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

    <div class="m-listing__meta">
        @if (isset($item['title']) and $item['title'])
            @if (isset($item['titleLink']) and $item['titleLink'])
                @component('components.atoms._title')
                    @slot('variation', 'title--w-right-arrow')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('tag', 'a')
                    @slot('href', $item['titleLink'])
                    @slot('gtmAttributes', $gtmAttributes ?? null)
                    {{ $item['title_display'] ?? $item['title'] }} <span class='title__arrow' aria-hidden="true">&rsaquo;</span>
                @endcomponent
            @else
                @component('components.atoms._title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('tag', 'span')
                    @slot('ariaHidden', 'true')
                    @slot('title', $item['title'])
                    @slot('title_display', $item['title_display'] ?? null)
                @endcomponent
            @endif
            <br>
        @endif
        @if (isset($item['text']) and $item['text'])
            @component('components.blocks._text')
                @slot('font', 'f-secondary')
                @slot('tag', 'div')
                {!! $item['text'] !!}
            @endcomponent
        @endif
        @if (isset($item['links']) and $item['links'])
            <br>
            @if (count($item['links']) > 1)
              <ul class="f-secondary" aria-labelledby="h-{{ str_slug($item['title']) }}">
            @else
              <span class="f-secondary last-child">
            @endif
            @foreach ($item['links'] as $link)
                {!! count($item['links']) > 1 ? '<li>' : '<span>' !!}
                    @if (isset($link['external']) and $link['external'])
                        <a href="{!! $link['href'] !!}" target="_blank" class="external-link f-link">
                            {!! $link['label'] !!}<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
                        </a>
                    @else
                        @component('components.atoms._arrow-link')
                            @slot('href', $link['href'])
                            @slot('gtmAttributes', $gtmAttributes ?? null)
                            {!! $link['label'] !!}
                        @endcomponent
                    @endif
                {!! count($item['links']) > 1 ? '</li>' : '</span>' !!}
            @endforeach
            {!! count($item['links']) > 1 ? '</ul>' : '</span>' !!}
        @endif
    </div>

</{{ $tag or 'li' }}>
