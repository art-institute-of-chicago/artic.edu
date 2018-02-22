<{{ $tag ?? 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}{{ $item->closingSoon ? " m-listing--limited" : "" }}{{ $item->exclusive ? " m-listing--membership" : "" }}">
  <a href="{{ route('events.show', $item) }}" class="m-listing__link">
    <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
        @if ($img = $item->imageAsArray('hero'))
            @component('components.atoms._img')
                @slot('image', $img)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        @endif
    </span>
    <span class="m-listing__meta">
        @if ($item->exclusive)
            @component('components.atoms._type')
                @slot('variation', 'type--membership')
                Member Exclusive
            @endcomponent
        @else
            @component('components.atoms._type')
                @if (method_exists($item, 'present'))
                    {{ $item->present()->type }}
                @else
                    {{ $item->type }}
                @endif
            @endcomponent
        @endif
        <br>
        @component('components.atoms._title')
            @slot('font', $titleFont ?? 'f-list-4')
            {{ $item->title }}
        @endcomponent
        @if (!isset($hideShortDesc) or !$hideShortDesc)
        <br>
        @component('components.atoms._short-description')
            {{ $item->shortDesc }}
        @endcomponent
        @endif
        <br>
        <span class="m-listing__meta-bottom">
            @component('components.atoms._date')
                {{ $item->timeStart }} &ndash; {{ $item->timeEnd }}
            @endcomponent
            @if ($item->free)
            <br>
            @component('components.atoms._tag')
                @slot('variation','tag--primary')
                @slot('tag','span')
                Free
            @endcomponent
            @endif
            @if ($item->register)
            <br>
            @component('components.atoms._tag')
                @slot('variation','tag--secondary')
                @slot('tag','span')
                Register
            @endcomponent
            @endif
            @if ($item->soldOut)
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
