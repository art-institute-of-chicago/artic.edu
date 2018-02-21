<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->is_member_exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ route('events.show', $item) }}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($img = $item->imageAsArray('hero'))
            @component('components.atoms._img')
                @slot('src', $img['src'])
                {{-- @slot('srcset', $img['srcset']) --}}
                @slot('width', $img['width'])
                @slot('height', $img['height'])
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
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
            {{ $item->forced_date }}
            @endcomponent
        @else
            @component('components.atoms._date')
                {{ $item->present()->nextOcurrenceDate }}
            @endcomponent
            <br>
            @component('components.atoms._date')
                {{ $item->present()->nextOcurrenceTime }}
            @endcomponent
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
