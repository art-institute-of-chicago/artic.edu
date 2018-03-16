<{{ $tag ?? 'li' }} class="m-listing m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->nowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $item->slug }}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($item->videoFront)
            @component('components.atoms._video')
                @slot('video', $item->videoFront)
                @slot('autoplay', true)
                @slot('loop', true)
                @slot('muted', true)
            @endcomponent
        @elseif ($item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        <span class="m-listing__types f-tag">
            @component('components.atoms._type')
                @slot('font', '')
                {{ $item->present()->exhibitionType }}
            @endcomponent

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
        </span>
        <br>
        @component('components.atoms._title')
            {{ $item->title }}
        @endcomponent
        <br>
        @if (isset($variation) && !strrpos($variation, "--row"))
            @component('components.atoms._date')
                Through {{ $item->dateEnd->format('M j, Y') }}
            @endcomponent
        @else
            <span class="m-listing__meta-bottom">
                @component('components.atoms._date')
                    {{ $item->dateStart->format('M j, Y') }} &ndash; {{ $item->dateEnd->format('M j, Y') }}
                @endcomponent
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
