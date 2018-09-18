@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {!! $page->title_display ?? $page->title !!}
@endcomponent

@component('components.molecules._m-intro-block')
    {{ $page->exhibition_intro }}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('isPrimaryPageNav', true)
    @slot('linksPrimary', array(array('label' => 'Exhibitions', 'href' => route('exhibitions'), 'active' => false), array('label' => 'Events', 'href' => route('events'), 'active' => true)))
@endcomponent

@component('components.organisms._o-sticky-filters')

    @component('components.molecules._m-links-bar', ['primaryVariation' => 'm-links-bar--centered@xsmall'])
        @slot('linksPrimary', array(
            array('label' => 'Today', 'href' => route('events', request()->only(['audience', 'program', 'type'])), 'active' => !request('start') && !request('time'), 'gtmAttributes' => 'data-gtm-event="event-today" data-gtm-event-action="Events" data-gtm-event-category="in-page-link"'),
            array('label' => 'This weekend', 'href' => route('events', request()->only(['audience', 'program', 'type']) + ['time' => 'weekend']), 'active' => (!request('start') && request('time') == 'weekend'), 'liVariation' => "u-hide@xsmall u-hide@small", 'gtmAttributes' => 'data-gtm-event="event-weekend" data-gtm-event-action="Events"  data-gtm-event-category="in-page-link"')
        ))
        @slot('primaryHtml')
            <li class="m-links-bar__item">
                @component('components.atoms._date-select-trigger')
                    @slot('gtmAttributes','data-gtm-event="event-calendar" data-gtm-event-category="in-page-link"')
                    @if (request('start') && request('end'))
                        {{ \Carbon\Carbon::parse(request('start'))->format('M j, Y') }} – {{ \Carbon\Carbon::parse(request('end'))->format('M j, Y') }}
                    @else
                        Pick a date
                    @endif
                @endcomponent
            </li>
        @endslot
        @slot('secondaryHtml')
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', request('type') ? \App\Models\Event::$eventTypes[request('type')] : 'All event types')
                  @slot('ariaTitle', 'Filter by')
                  @slot('variation','dropdown--filter f-link')
                  @slot('font', null)
                  @slot('options', $eventTypesLinks)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                  @slot('prompt', request('audience') ? \App\Models\Event::$eventAudiences[request('audience')] : 'All audiences')
                  @slot('ariaTitle', 'Filter by')
                  @slot('variation','dropdown--filter f-link')
                  @slot('font', null)
                  @slot('options', $eventAudiencesLinks)
                @endcomponent
            </li>
        @endslot
    @endcomponent

    @if (empty($eventsByDay) or (isset($eventsByDay) and count($eventsByDay) == 0))
        @component('components.molecules._m-no-results')
        @endcomponent
    @else
        @if ($subtitle)
            @component('components.molecules._m-results-title')
                @slot('subtitle', $subtitle)
                @slot('links', array(array('label' => 'See all events', 'href' => route('events') )))
            @endcomponent
        @endif

        @component('components.organisms._o-row-listing')
            @slot('id', 'eventsList')

            @component('site.events._items')
                @slot('eventsByDay', $eventsByDay)
                @slot('ongoing', $ongoing)
            @endcomponent
        @endcomponent

        @if ($collection->hasMorePages())
            @component('components.molecules._m-links-bar')
                @slot('variation', 'm-links-bar--buttons')
                @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary', 'loadMoreUrl' => route('events.more', request()->all()), 'loadMoreTarget' => '#eventsList')))
            @endcomponent
        @endif
    @endif

@endcomponent

@endsection
