@if (isset($formattedDate))
    @component('components.atoms._date')
        @slot('tag', $tag ?? null)
        @slot('font', $font ?? null)
        {!! $formattedDate !!}
    @endcomponent
@elseif (empty($dateStart) and empty($dateEnd))
    {{-- Nothing we can do --}}
@elseif (!empty($dateStart) and empty($dateEnd))
    @component('components.atoms._date')
        @slot('tag', $tag ?? null)
        @slot('font', $font ?? null)
        <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time>
    @endcomponent
@elseif (empty($dateStart))
    {{-- Intentionally left blank --}}
@elseif ($dateStart and $dateEnd)
    @component('components.atoms._date')
        @slot('tag', $tag ?? null)
        @slot('font', $font ?? null)
        @if($dateStart->format("Y") == $dateEnd->format("Y"))
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j') }}</time>&ndash;<time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
        @else
            <time datetime="{{ $dateStart->format("Y-m-d") }}" itemprop="startDate">{{ $dateStart->format('M j, Y') }}</time>&ndash;<time datetime="{{ $dateEnd->format("Y-m-d") }}" itemprop="endDate">{{ $dateEnd->format('M j, Y') }}</time>
        @endif
    @endcomponent
@elseif (!empty($date))
    @component('components.atoms._date')
        @slot('tag', $tag ?? null)
        @slot('font', $font ?? null)
        <time datetime="{{ $date->format("Y-m-d") }}" itemprop="startDate">{{ $date->format('F j, Y') }}</time>
    @endcomponent
@endif
