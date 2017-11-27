@php
$feature = isset($feature) ? $feature : false;
$hero = isset($hero) ? $hero : false;
@endphp
<{{ $tag or 'li' }} class="m-listing{{ $feature ? " m-listing--feature" : "" }}{{ ($feature and $hero) ? " o-features__hero-100vw" : "" }}{{ $exhibition->closingSoon ? " m-listing--limited" : "" }}{{ $exhibition->nowOpen ? " m-listing--new" : "" }}{{ $exhibition->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $exhibition->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
      <span class="m-listing__meta-top">
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
        @if ($feature and $hero)
            @component('components.atoms._date')
                {{ $exhibition->dateStart }} - {{ $exhibition->dateEnd }}
            @endcomponent
        @endif
      </span><br>
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            {{ $exhibition->title }}
        @endcomponent
      @if (!$feature)
      <br><span class="m-listing__meta-bottom">
        @component('components.atoms._date')
            Through {{ $exhibition->dateEnd }}
        @endcomponent
      </span>
      @endif
    </span>
  </a>
</{{ $tag or 'li' }}>
