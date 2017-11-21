@php
$feature = isset($feature) ? $feature : false;
$hero = isset($hero) ? $hero : false;
@endphp
<{{ $tag or 'li' }} class="m-listing{{ $feature ? " m-listing--feature" : "" }}{{ ($feature and $hero) ? " o-features__hero-100vw" : "" }}">
  <a href="{{ $exhibition->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $exhibition->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
      <span class="m-listing__meta-top">
        @component('components.atoms._type')
            {{ $exhibition->type }}
        @endcomponent
        @if ($exhibition->closingSoon)
            @component('components.atoms._type')
                @slot('tag', 'span')
                Closing Soon
            @endcomponent
        @endif
        @if ($feature and $hero)
            @component('components.atoms._date')
                {{ $exhibition->dateStart }} - {{ $exhibition->dateEnd }}
            @endcomponent
        @endif
      </span><br>
        @component('components.atoms._title')
            @if ($feature and $hero)
                @slot('font','f-display-1')
            @else
                @slot('font','f-module-title-1')
            @endif
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
