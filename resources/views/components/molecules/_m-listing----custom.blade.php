@php
    if (isset($variation) and ((strrpos($variation, '--hero') > 0) or (strrpos($variation, '--feature') > 0))) {
        $hoverBar = '';
    } else {
        $hoverBar = ' m-listing--hover-bar';
    }
@endphp
  <{{ $tag or 'li' }} class="m-listing m-listing--w-meta-bottom{{ $hoverBar }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront()) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{!! $item->url !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>

    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront()) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront()) ? ' data-blur-img' : '' }}>
        @if (isset($image) || $item->imageFront('hero'))
            @component('components.atoms._img')
                @slot('image', $image ?? $item->imageFront('hero'))
                @slot('settings', $imageSettings ?? '')
            @endcomponent
            @if ($item->videoFront())
                @component('components.atoms._video')
                    @slot('video', $item->videoFront())
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                    @slot('title', $item->videoFront()['fallbackImage']['alt'] ?? $item->imageFront('hero')['alt'] ?? $image['alt'] ?? null)
                @endcomponent
                @component('components.atoms._media-play-pause-video')
                @endcomponent
            @endif
        @else
            <span class="default-img"></span>
        @endif
        <span class="m-listing__img__overlay"></span>
    </span>
    <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
      <span class="m-listing__types f-tag">
        @component('components.atoms._type')
            @slot('variation', 'type--membership')
            @slot('font', '')
            {!! $item->tag !!}
        @endcomponent
      </span>
      <br>
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            @slot('title', $item->title)
            @slot('title_display', $item->title_display)
        @endcomponent
        <br>
        @component('components.atoms._short-description')
            @slot('variation', 'show')
            {!! truncateStr($item->call_to_action) !!}
        @endcomponent
        <br>
    </span>
  </a>
</{{ $tag or 'li' }}>
