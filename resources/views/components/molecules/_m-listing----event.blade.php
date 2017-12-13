<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $event->closingSoon ? " m-listing--limited" : "" }}{{ $event->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $event->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $event->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
    @if (!isset($variation) or $variation !== 'm-listing--hero')
        @if ($event->exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                {{ $event->type }}
            @endcomponent
        @endif
      <br>
    @endif
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-3')
            {{ $event->title }}
        @endcomponent
      <br>
      <span class="m-listing__meta-bottom">
        @component('components.atoms._date')
            {{ $event->dateFormatted }}
        @endcomponent
        <br>
        @component('components.atoms._date')
            {{ $event->timeStart }}-{{ $event->timeEnd }}
        @endcomponent
      </span>
    </span>
  </a>
</{{ $tag or 'li' }}>
