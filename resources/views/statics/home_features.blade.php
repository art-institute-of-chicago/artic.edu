@extends('layouts.app')

@section('content')

@component('components.organisms._o-features')
    @foreach ($heroItems as $item)
        @component('components.molecules._m-listing----'.$item->listingType)
            @slot('item', $item)
            @slot('variation', 'm-listing--hero')
            @slot('titleFont', 'f-display-1')
            @slot('imageSettings', array(
                'srcset' => array(300,600,1000,1500,3000),
                'sizes' => '100vw',
            ))
        @endcomponent
    @endforeach
@endcomponent



@component('components.organisms._o-features')
    @foreach ($heroItems as $item)
        @component('components.molecules._m-listing----'.$item->listingType)
            @slot('item', $item)
            @slot('variation', 'm-listing--feature')
            @slot('titleFont', 'f-module-title-2')
            @slot('imageSettings', array(
                'srcset' => array(300,600,1000,1500,3000),
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

@endsection
