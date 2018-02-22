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
        array('label' => 'Today', 'href' => '#', 'active' => true),
        array('label' => 'Tomorrow', 'href' => '#', 'liVariation' => "u-hide@xsmall u-hide@small u-hide@medium"),
        array('label' => 'This weekend', 'href' => '#', 'liVariation' => "u-hide@xsmall u-hide@small")
    ))
    @slot('primaryHtml')
        <li class="m-links-bar__item">
            @component('components.atoms._date-select-trigger')
                Select dates
            @endcomponent
        </li>
    @endslot
    @slot('secondaryHtml')
        <li class="m-links-bar__item m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', 'All event types')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter f-buttons')
              @slot('font', 'f-buttons')
              @slot('options', array(
                array('href' => '#', 'label' => 'All event types'),
                array('href' => '#', 'label' => 'Classes and workshops'),
                array('href' => '#', 'label' => 'Live Arts'),
                array('href' => '#', 'label' => 'Screenings'),
                array('href' => '#', 'label' => 'Special Events'),
                array('href' => '#', 'label' => 'Talks'),
                array('href' => '#', 'label' => 'Tours'),
              ))
            @endcomponent
        </li>
        <li class="m-links-bar__item m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', 'All audiences')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter f-buttons')
              @slot('font', 'f-buttons')
              @slot('options', array(
                array('href' => '#', 'label' => 'All audiences'),
                array('href' => '#', 'label' => 'Classes and workshops'),
                array('href' => '#', 'label' => 'Live Arts'),
                array('href' => '#', 'label' => 'Screenings'),
                array('href' => '#', 'label' => 'Special Events'),
                array('href' => '#', 'label' => 'Talks'),
                array('href' => '#', 'label' => 'Tours'),
              ))
            @endcomponent
        </li>
    @endslot
@endcomponent

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


@endsection
