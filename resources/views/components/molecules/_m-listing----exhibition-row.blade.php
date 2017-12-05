<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $exhibition->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
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
        @elseif ($exhibition->exclusive)
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
        @component('components.atoms._title')
            {{ $exhibition->title }}
        @endcomponent
        <br>
        @component('components.atoms._date')
            Through {{ $exhibition->dateEnd }}
        @endcomponent
    </span>
  </a>
</{{ $tag ?? 'li' }}>
