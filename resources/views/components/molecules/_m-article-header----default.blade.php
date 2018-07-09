<{{ $tag or 'header' }} class="m-article-header m-article-header--default{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (!empty($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
            @slot('itemprop','name')
            {{ $title }}
        @endcomponent
    @endif
    @if (isset($formattedDate))
        @component('components.atoms._date')
            @slot('tag','p')
            {!! $formattedDate !!}
        @endcomponent
     @elseif (empty($dateEnd))
           @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time> 
            @endcomponent
      @elseif (empty($dateStart))
      @elseif (empty($dateStart) and empty($dateEnd))
    @elseif ($dateStart and $dateEnd)
        @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time> &ndash; <time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
        @endcomponent
    @elseif (!empty($date))
        @component('components.atoms._date')
            @slot('tag','p')
            <time datetime="{{ $date->format("Y-m-d") }}" itemprop="startDate">{{ $date->format('F j, Y') }}</time>
        @endcomponent
    @endif
    @if (!empty($type))
        @component('components.atoms._type')
            @slot('tag','p')
            {{ $type }}
        @endcomponent
    @endif
</{{ $tag or 'header' }}>
