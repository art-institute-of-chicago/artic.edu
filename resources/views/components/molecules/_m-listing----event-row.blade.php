<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $event->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $event->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
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
        @component('components.atoms._title')
            {{ $event->title }}
        @endcomponent
        <br>
        @component('components.atoms._date')
            {{ $event->timeStart }}-{{ $event->timeEnd }}
        @endcomponent
    </span>
  </a>
</{{ $tag ?? 'li' }}>
