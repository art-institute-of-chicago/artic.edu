<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $exhibition->closingSoon ? " m-listing--limited" : "" }}{{ $exhibition->nowOpen ? " m-listing--new" : "" }}{{ $exhibition->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $exhibition->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
    @if (!isset($variation) or $variation !== 'm-listing--hero')
        @if ($exhibition->exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                {{ $exhibition->type }}
            @endcomponent
        @endif
      <br>
    @endif
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            {{ $exhibition->title }}
        @endcomponent
      <br>
      <span class="m-listing__meta-bottom">
        @if ($exhibition->closingSoon)
            @component('components.atoms._type')
                @slot('variation', 'type--limited')
                Closing Soon
            @endcomponent
        @elseif ($exhibition->nowOpen)
            @component('components.atoms._type')
                @slot('variation', 'type--new')
                Now Open
            @endcomponent
        @else
            @component('components.atoms._date')
                {{ $exhibition->dateStart }} - {{ $exhibition->dateEnd }}
            @endcomponent
        @endif
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
