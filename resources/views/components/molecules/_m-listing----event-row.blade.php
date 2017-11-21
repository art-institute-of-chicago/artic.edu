<li class="m-listing m-listing--row{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $event->slug }}" class="m-listing__link">
    <span class="m-listing__img">
        @component('components.atoms._img')
            @slot('src', $event->image['src'])
        @endcomponent
    </span>
    <span class="m-listing__meta">
        @if ($event->exclusive)
            @component('components.atoms._exclusive')
                Member Exclusive
            @endcomponent
        @endif
        @component('components.atoms._type')
            {{ $event->type }}
        @endcomponent
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
</li>
