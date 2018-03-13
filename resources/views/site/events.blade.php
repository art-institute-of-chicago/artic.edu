@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $page->title }}
@endcomponent

@component('components.molecules._m-intro-block')
    {{ $page->exhibition_intro }}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('linksPrimary', array(array('label' => 'Exhibitions', 'href' => route('exhibitions'), 'active' => false), array('label' => 'Events', 'href' => route('events'), 'active' => true)))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(
        array('label' => 'Today', 'href' => route('events'), 'active' => !request('start') && !request('time')),
        array('label' => 'Tomorrow', 'href' => route('events', ['time' => 'tomorrow']), 'active' => (!request('start') && request('time') == 'tomorrow'), 'liVariation' => "u-hide@xsmall u-hide@small u-hide@medium"),
        array('label' => 'This weekend', 'href' => route('events', ['time' => 'weekend']), 'active' => (!request('start') && request('time') == 'weekend'), 'liVariation' => "u-hide@xsmall u-hide@small")
    ))
    @slot('primaryHtml')
        <li class="m-links-bar__item">
            @component('components.atoms._date-select-trigger')
                @if (request('start') && request('end'))
                    {{ \Carbon\Carbon::parse(request('start'))->format('d M, Y') }} - {{ \Carbon\Carbon::parse(request('end'))->format('d M, Y') }}
                @else
                    Select dates
                @endif
            @endcomponent
        </li>
    @endslot
    @slot('secondaryHtml')
        <li class="m-links-bar__item m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', request('type') ? \App\Models\Event::$eventTypes[request('type')] : 'All event types')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter f-buttons')
              @slot('font', 'f-buttons')
              @slot('options', $eventTypesLinks)
            @endcomponent
        </li>
        <li class="m-links-bar__item m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', request('audience') ? \App\Models\Event::$eventAudiences[request('audience')] : 'All audiences')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter f-buttons')
              @slot('font', 'f-buttons')
              @slot('options', $eventAudiencesLinks)
            @endcomponent
        </li>
    @endslot
@endcomponent

@if (empty($eventsByDay) or (isset($eventsByDay) and count($eventsByDay) == 0))
    <div class="o-collection-listing__no-results">
        @component('components.atoms._hr')
        @endcomponent
        @component('components.atoms._title')
            @slot('tag','h2')
            @slot('font', 'f-list-3')
            Sorry, we couldn't find any results matching your criteria
        @endcomponent
    </div>
@else
    @component('components.organisms._o-row-listing')
        @foreach ($eventsByDay as $date => $events)
            @component('components.molecules._m-date-listing')
                @slot('date', $date)
                @slot('events', $events)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '13',
                          'medium' => '13',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
                @slot('imageSettingsOnGoing', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '7',
                          'medium' => '7',
                          'large' => '7',
                          'xlarge' => '7',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('label' => 'See more events', 'href' => '#', 'variation' => 'btn--secondary')))
    @endcomponent
@endif


@endsection
