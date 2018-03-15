<{{ $tag or 'header' }} class="m-article-header{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            {{ $title }}
        @endcomponent
    @endif
    @if (isset($formattedDate))
        @component('components.atoms._date')
            {!! $formattedDate !!}
        @endcomponent
    @elseif ($dateStart and $dateEnd)
        @component('components.atoms._date')
            {{ $dateStart->format('M j, Y') }} &ndash; {{ $dateEnd->format('M j, Y') }}
        @endcomponent
    @elseif (!empty($date))
        @component('components.atoms._date')
            @slot('tag','p')
            {{ $date->format('F j, Y') }}
        @endcomponent
    @endif
    @if (isset($type))
        @component('components.atoms._type')
            @slot('tag','p')
            {{ $type }}
        @endcomponent
    @endif
</{{ $tag or 'header' }}>
