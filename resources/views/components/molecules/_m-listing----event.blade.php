@php
    if (isset($variation) and ((strrpos($variation, '--hero') > 0) or (strrpos($variation, '--feature') > 0))) {
        $hoverBar = '';
    } else {
        $hoverBar = ' m-listing--hover-bar';
    }
@endphp
<{{ $tag or 'li' }} class="m-listing m-listing--w-meta-bottom{{ $hoverBar }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->is_member_exclusive ? " m-listing--membership" : "" }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/VisualArtsEvent">
  <a href="{{ route('events.show', $item) }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
        @if (isset($image) || $item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $image ?? $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                    @slot('title', $item->videoFront['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? $image['alt'] ?? null)
                @endcomponent
                @component('components.atoms._media-play-pause-video')
                @endcomponent
            @endif
        @else
            <span class="default-img"></span>
        @endif
    </span>
    <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
    @if (!isset($variation) or $variation !== 'm-listing--hero')
        @if ($item->is_member_exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                {{ $item->present()->type }}
            @endcomponent
        @endif
      <br>
    @endif
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            {{ $item->title }}
        @endcomponent
      <br>
      <span class="m-listing__meta-bottom">
        @if (!empty($item->forced_date))
            @component('components.atoms._date')
            {!! $item->forced_date !!}
            @endcomponent
        @else
            @component('components.atoms._date')
                {!! $item->present()->nextOcurrenceDate !!}
            @endcomponent
            <br>
            @component('components.atoms._date')
                {!! $item->present()->nextOcurrenceTime !!}
            @endcomponent
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
