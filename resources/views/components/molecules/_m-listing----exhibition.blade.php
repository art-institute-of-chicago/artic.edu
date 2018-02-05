<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->nowOpen ? " m-listing--new" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $item->slug }}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--wide' }}">
        @if ($item->image)
            @component('components.atoms._img')
                @slot('src', $item->image['src'])
                @slot('srcset', $item->image['srcset'])
                @slot('width', $item->image['width'])
                @slot('height', $item->image['height'])
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
    @if (!isset($variation) or $variation !== 'm-listing--hero')
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
                {{ date( 'M j, Y', intval($item->dateStart)) }} &ndash; {{ date( 'M j, Y', intval($item->dateEnd)) }}
            @endcomponent
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
