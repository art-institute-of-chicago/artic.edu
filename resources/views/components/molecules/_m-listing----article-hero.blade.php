<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{!! route('articles.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}" data-blur-img>
            @if ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @component('components.molecules._m-listing-video')
                    @slot('item', $item)
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
        <span class="m-listing__meta" data-blur-clip-to>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            <br>
            <span class="intro {{ $captionFont ?? 'f-caption' }}">{!! StringHelpers::truncateStr($item->present()->list_description) !!}</span>
            <br>
            <span class="m-listing__meta-bottom">
                @if ($item->subtype)
                    @component('components.atoms._type')
                        {!! $item->present()->subtype !!}
                    @endcomponent
                <br>
                @endif
                @if ($item->date)
                    @component('components.atoms._date')
                        {{ $item->date->format('F j, Y') }}
                    @endcomponent
                @endif
            </span>
        </span>
    </a>
</{{ $tag ?? 'li' }}>
