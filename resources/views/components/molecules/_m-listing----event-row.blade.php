<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $event->closingSoon ? " m-listing--limited" : "" }}{{ $event->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ $event->slug }}" class="m-listing__link">
    <span class="m-listing__img m-listing__img--wide">
        @component('components.atoms._img')
            @slot('src', $event->image['src'])
            @slot('width', $event->image['width'])
            @slot('height', $event->image['height'])
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
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $event->title }}
        @endcomponent
        @if (!isset($hideShortDesc) or !$hideShortDesc)
        <br>
        @component('components.atoms._short-description')
            {{ $event->shortDesc }}
        @endcomponent
        @endif
        <br>
        <span class="m-listing__meta-bottom">
            @component('components.atoms._date')
                {{ $event->timeStart }}-{{ $event->timeEnd }}
            @endcomponent
            @if ($event->free)
            <br>
            @component('components.atoms._tag')
                @slot('variation','tag--primary')
                @slot('tag','span')
                Free
            @endcomponent
            @endif
            @if ($event->register)
            <br>
            @component('components.atoms._tag')
                @slot('variation','tag--secondary')
                @slot('tag','span')
                Register
            @endcomponent
            @endif
            @if ($event->soldOut)
            <br>
            @component('components.atoms._tag')
                @slot('variation','tag--tertiary')
                @slot('tag','span')
                Sold Out
            @endcomponent
            @endif
        </span>
    </span>
  </a>
</{{ $tag ?? 'li' }}>
