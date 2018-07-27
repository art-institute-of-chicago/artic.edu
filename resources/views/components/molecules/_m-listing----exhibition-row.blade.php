<{{ $tag ?? 'li' }} class="m-listing m-listing--w-meta-bottom m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->nowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}" itemscope itemtype="http://schema.org/ExhibitionEvent">
  <a href="{{ $item->slug }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}">
        @if ($item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                    @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? null)
                @endcomponent
                @component('components.atoms._media-play-pause-video')
                @endcomponent
            @endif
        @else
            <span class="default-img"></span>
        @endif
    </span>
    <span class="m-listing__meta">
        <span class="m-listing__types f-tag">
            @component('components.atoms._type')
                @slot('font', '')
                {{ $item->present()->exhibitionType }}
            @endcomponent

            @if ($item->isClosed)
                @component('components.atoms._type')
                    @slot('variation', 'type--limited')
                    @slot('font', '')
                    Closed
                @endcomponent
            @else
                @if ($item->closingSoon)
                    @component('components.atoms._type')
                        @slot('variation', 'type--limited')
                        @slot('font', '')
                        Closing Soon
                    @endcomponent
                @elseif ($item->nowOpen)
                    @component('components.atoms._type')
                        @slot('variation', 'type--new')
                        @slot('font', '')
                        Now Open
                    @endcomponent
                @elseif ($item->exclusive)
                    @component('components.atoms._type')
                        @slot('variation', 'type--membership')
                        @slot('font', '')
                        Member Exclusive
                    @endcomponent
                @endif
            @endif
        </span>
        <br>
        @component('components.atoms._title')
            {{ $item->title }}
        @endcomponent
        <br>
        @if ($item->list_description)
            @component('components.atoms._short-description')
                {{ $item->list_description }}
            @endcomponent
            <br>
        @endif
        @if (isset($variation) && !strrpos($variation, "--row"))
            @component('components.atoms._date')
                Through {{ $item->dateEnd->format('M j, Y') }}
            @endcomponent
        @else
            <span class="m-listing__meta-bottom">
                @component('components.atoms._date')
                    {!! $item->present()->formattedDate !!}
                @endcomponent
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
