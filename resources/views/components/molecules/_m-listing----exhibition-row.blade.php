<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $exhibition->closingSoon ? " m-listing--limited" : "" }}{{ $exhibition->nowOpen ? " m-listing--new" : "" }}{{ $exhibition->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--wide">
        @component('components.atoms._img')
            @slot('src', $exhibition->image['src'])
            @slot('width', $exhibition->image['width'])
            @slot('height', $exhibition->image['height'])
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
        @if (isset($variation) && !strrpos($variation, "--row"))
            @component('components.atoms._date')
                Through {{ $exhibition->dateEnd }}
            @endcomponent
        @else
            <span class="m-listing__meta-bottom">
                @component('components.atoms._date')
                    {{ $exhibition->dateStart }} - {{ $exhibition->dateEnd }}
                @endcomponent
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
