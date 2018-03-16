@php
    if (isset($variation) and ((strrpos($variation, '--hero') > 0) or (strrpos($variation, '--feature') > 0))) {
        $hoverBar = '';
    } else {
        $hoverBar = ' m-listing--hover-bar';
    }
@endphp
<{{ $tag or 'li' }} class="m-listing{{ $hoverBar }}{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->nowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{!! route('exhibitions.show', $item) !!}" class="m-listing__link">

    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
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
        @endif
      </span>
      <br>
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            {{ $item->title }}
        @endcomponent
      <br>
      <span class="m-listing__meta-bottom">
        @component('components.atoms._date')
            {{ $item->dateStart->format('M j, Y') }} &ndash; {{ $item->dateEnd->format('M j, Y') }}
        @endcomponent
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
