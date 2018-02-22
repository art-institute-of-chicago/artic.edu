@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $title }}
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('linksPrimary', array(array('label' => 'Exhibitions', 'href' => '#', 'active' => true), array('label' => 'Events', 'href' => '#', 'active' => false)))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(
        array('label' => 'Current', 'href' => '#', 'active' => true),
        array('label' => 'Upcoming', 'href' => '#'),
        array('label' => 'Archive', 'href' => '#', 'liVariation' => 'm-links-bar__item--push')
    ))
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','2')
    @slot('cols_large','2')
    @slot('cols_xlarge','2')
    @foreach ($featuredExhibitions as $item)
        @component('components.molecules._m-listing----exhibition')
            @slot('item', $item)
            @slot('titleFont', 'f-list-4')
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000,1500),
                'sizes' => aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '2',
                      'medium' => '2',
                      'large' => '2',
                      'xlarge' => '2',
                )),
            ))
        @endcomponent
    @endforeach
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($exhibitions as $item)
        @if ($loop->index < 6)
            @component('components.molecules._m-listing----exhibition')
               @slot('item', $item)
               @slot('imageSettings', array(
                   'fit' => 'crop',
                   'ratio' => '16:9',
                   'srcset' => array(200,400,600,1000),
                   'sizes' => aic_gridListingImageSizes(array(
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

@component('components.molecules._m-aside-newsletter')
    @slot('variation', 'm-aside-newsletter--wide')
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($exhibitions as $item)
        @if ($loop->index > 5)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600,1000),
                    'sizes' => aic_gridListingImageSizes(array(
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

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', array(array('label' => 'Upcoming Exhibits', 'href' => '#', 'variation' => 'btn--secondary')))
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse events', 'href' => '#')))
    Today&rsquo;s Events
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


@endsection
