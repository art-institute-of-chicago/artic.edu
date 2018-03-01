<{{ $tag or 'li' }} class="m-listing m-listing--hover-bar{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->nowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}"{!! (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-behavior="blurMyBackground"' : '' !!}>
    <a href="{!! route('exhibitions.show', $item) !!}" class="m-listing__link">

    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-img' : '' }}>
        @if ($img = $item->imageAsArray('hero'))
            @component('components.atoms._img')
                @slot('image', $img)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
    @if (!isset($variation) or strrpos($variation, "--hero") < 0)
        @if ($item->exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                {{ $item->type }}
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
        @if ($item->closingSoon)
            @component('components.atoms._type')
                @slot('variation', 'type--limited')
                Closing Soon
            @endcomponent
        @elseif ($item->nowOpen)
            @component('components.atoms._type')
                @slot('variation', 'type--new')
                Now Open
            @endcomponent
        @else
            @component('components.atoms._date')
                {{ $item->dateStart->format('M j, Y') }} &ndash; {{ $item->dateEnd->format('M j, Y') }}
            @endcomponent
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
