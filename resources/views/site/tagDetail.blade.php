@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $item->title }}
@endcomponent

    @component('components.organisms._o-artist-bio')
        @slot('item', $item)
        @slot('imageSettings', array(
            'srcset' => array(200,400,600,1000,1500,2000),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '58',
                  'medium' => '58',
                  'large' => '28',
                  'xlarge' => '28',
            )),
        ))
    @endcomponent

@unless ($artworks->isEmpty())
    @component('components.molecules._m-title-bar')
        Artworks
    @endcomponent

    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','true')
        @foreach ($artworks as $artwork)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $artwork)
                @slot('imageSettings', array(
                    'fit' => null,
                    'ratio' => null,
                    'srcset' => array(200,400,600,1000),
                    'sizes' => aic_gridListingImageSizes(array(
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
@endunless

@if ($artworks->total() > 8)
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(
            [
                'label' => "See all {$artworks->total()} artworks",
                'href'  => $item->present()->collectionFilteredUrl,
                'variation' => 'btn--secondary'
            ]
        ));
    @endcomponent
@endif

@if ($item->articles)
    @component('components.molecules._m-title-bar')
        Related
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($item->articles as $item)
            @component('components.molecules._m-listing----article')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600,1000),
                    'sizes' => aic_gridListingImageSizes(array(
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

@if ($exploreFurther || $exploreFurtherAllTags)
<div id="exploreFurther">
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent

    @component('site.shared._explore-further-menu')
        @slot('tags', $exploreFurtherTags)
    @endcomponent

    @if ($exploreFurther && !$exploreFurther->isEmpty())
        @component('components.organisms._o-pinboard')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('maintainOrder','false')
            @foreach ($exploreFurther as $item)
                @component('components.molecules._m-listing----artwork')
                    @slot('variation', 'o-pinboard__item')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => null,
                        'ratio' => null,
                        'srcset' => array(200,400,600),
                        'sizes' => aic_gridListingImageSizes(array(
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

    @if ($exploreFurtherAllTags)
        @component('components.molecules._m-multi-col-list')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('items', $exploreFurtherAllTags)
        @endcomponent
    @endif
</div>
@endif

@if ($item->exhibitions)
    @component('components.molecules._m-title-bar')
        Exhibitions
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @foreach ($item->exhibitions as $item)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection
