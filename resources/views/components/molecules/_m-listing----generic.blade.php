<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! $item->url !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
            @if (isset($video) || $item->videoFront)
                @component('components.atoms._video')
                    @slot('video', ($video ?? $item->videoFront))
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif (isset($image) || method_exists($item, 'imageFront'))
                @component('components.atoms._img')
                    @slot('image', ($image ?? $item->imageFront('default')))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @else
                <span class="default-img"></span>
            @endif
        </span>
        <span class="m-listing__meta">
            @if ($item->subtype)
            <em class="type f-tag">{{ $item->subtype }}</em>
            <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item->title }}
            @endcomponent
            @if ($item->intro)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->intro }}</span>
            @endif
            @if ($item->shortDesc)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->shortDesc }}</span>
            @endif
            @if ($item->listing_description)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">{{ $item->listing_description }}</span>
            @endif
            @if (isset($date))
                @if(!empty($date))
                    <br>
                    @component('components.atoms._date')
                        {{ $date }}
                    @endcomponent
                @endif
            @else
                @if ($item->date && (!isset($childBlock)))
                    <br>
                    @component('components.atoms._date')
                        {{ $item->date }}
                    @endcomponent
                @endif
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
