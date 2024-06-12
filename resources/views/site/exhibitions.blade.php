@extends('layouts.app')

@section('content')

@if (!empty($hour))
    @component('components.organisms._o-hours')
        @slot('hour', $hour)
    @endcomponent
@endif

@component('components.molecules._m-header-block')
    {!! $page->present()->title_display ?? $page->present()->title !!}
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $page->present()->exhibition_intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('isPrimaryPageNav', true)
    @slot('linksPrimary', array(array('label' => 'Exhibitions', 'href' => route('exhibitions'), 'active' => true), array('label' => 'Events', 'href' => route('events'), 'active' => false)))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(
        array('label' => 'Current', 'href' => route('exhibitions'), 'active' => !$upcoming),
        array('label' => 'Upcoming', 'href' => route('exhibitions.upcoming'), 'active' => $upcoming),
        array('label' => 'Archive', 'href' => route('exhibitions.history'), 'liVariation' => 'm-links-bar__item--push')
    ))
@endcomponent

@component('components.atoms._hr')
@endcomponent

@if ($featured->count() > 0)
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @foreach ($featured as $item)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
                @slot('titleFont', 'f-list-4')
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600,1000,1500),
                    'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '2',
                          'large' => '2',
                          'xlarge' => '2',
                    )),
                ))
            @endcomponent
            @if ($loop->index == 1)
                @break
            @endif
        @endforeach
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent
@endif

@if ($collection->count() > 0)
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @foreach ($collection as $item)
            @if ($loop->index < 6)
                @component('components.molecules._m-listing----exhibition')
                   @slot('item', $item)
                   @slot('imageSettings', array(
                       'fit' => 'crop',
                       'ratio' => '16:9',
                       'srcset' => array(200,400,600,1000),
                       'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                             'xsmall' => '1',
                             'small' => '2',
                             'medium' => '3',
                             'large' => '3',
                             'xlarge' => '3',
                       )),
                   ))
                @endcomponent
            @endif
        @endforeach
    @endcomponent
@endif

@component('components.molecules._m-aside-newsletter')
    @slot('variation', 'm-aside-newsletter--wide')
@endcomponent

@component('components.atoms._hr')
@endcomponent

@if ($collection->count() > 5)
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @foreach ($collection as $item)
            @if ($loop->index > 5)
                @component('components.molecules._m-listing----exhibition')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600,1000),
                        'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                              'xsmall' => '1',
                              'small' => '2',
                              'medium' => '3',
                              'large' => '3',
                              'xlarge' => '3',
                        )),
                    ))
                @endcomponent
            @endif
        @endforeach
    @endcomponent
@endif

@unless($upcoming)
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('label' => 'Upcoming exhibitions', 'href' => route('exhibitions.upcoming'), 'variation' => 'btn--secondary')))
    @endcomponent
@endunless

@if (!empty($eventsByDay) && $eventsByDay->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Browse events', 'href' => route('events'))))
        Upcoming Events
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
        @slot('linksPrimary', array(array('label' => 'Browse events', 'href' => route('events'), 'variation' => 'btn--secondary')))
    @endcomponent
@endif

@endsection
