@php
    if (isset($variation) and ((strrpos($variation, '--hero') > 0) or (strrpos($variation, '--feature') > 0))) {
        $hoverBar = '';
    } else {
        $hoverBar = ' m-listing--hover-bar';
    }
@endphp
<{{ $tag or 'li' }} class="m-listing m-listing--w-meta-bottom{{ $hoverBar }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->isClosingSoon ? " m-listing--limited" : "" }}{{ $item->isNowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!} itemscope itemtype="http://schema.org/ExhibitionEvent">
    <a href="{!! route('exhibitions.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>

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
      <span class="m-listing__types f-tag">
        @if ($item->exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                @slot('font', '')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                @slot('font', '')
                {{ $item->present()->exhibitionType }}
            @endcomponent
        @endif

        @if ($item->isClosed)
            @component('components.atoms._type')
                @slot('variation', 'type--limited')
                @slot('font', '')
                Closed
            @endcomponent
        @else
            @if ($item->isClosingSoon)
                @component('components.atoms._type')
                    @slot('variation', 'type--limited')
                    @slot('font', '')
                    Closing Soon
                @endcomponent
            @elseif ($item->isNowOpen)
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
            @slot('font', $titleFont ?? 'f-list-3')
            @slot('title', $item->title)
            @slot('title_display', $item->title_display)
        @endcomponent
        <br>
        @if (!empty($variation) && $variation !== 'm-listing--hero' && $item->list_description)
            @component('components.atoms._short-description')
                {!! truncateStr($item->list_description) !!}
            @endcomponent
            <br>
        @endif
        @if (!empty($variation) && $variation === 'm-listing--hero')
            @component('components.organisms._o-preview-dates')
                @slot('previewDateStart', $item->member_preview_start_date)
                @slot('previewDateEnd', $item->member_preview_end_date)
            @endcomponent
            <br>
        @endif
        {{-- <span class="m-listing__meta-bottom"> --}}
            @component('components.atoms._date')
                {!! $item->present()->formattedDate !!}
            @endcomponent
        {{-- </span> --}}
    </span>
  </a>
</{{ $tag or 'li' }}>
