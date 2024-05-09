@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
AIC Vector Search
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('variation', 'm-search-bar--vector')
    @slot('placeholder', 'Search using semantic search')
    @slot('value', request('query'))
    @slot('action', route('semanticSearch'))
    @slot('name', 'query')
    @slot('dataAttributes', 'data-url="'. route('semanticSearch').'"')
@endcomponent

@if ($input)
    <p class="title f-list-2">Showing results for <i>'{{$input}}'</i></p>
@endif
@if ($items)
    @component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @foreach ($items as $item)
        @component('components.molecules._m-listing----'.$item->type)
            @slot('item', $item)
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000),
                'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
                      'xsmall' => '1',
                      'small' => '2',
                      'medium' => '3',
                      'large' => '4',
                      'xlarge' => '4',
                )),
            ))
        @endcomponent
    @endforeach
    @endcomponent
@endif
@endsection