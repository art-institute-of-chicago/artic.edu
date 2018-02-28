@extends('layouts.app')

@section('content')

@component('components.molecules._m-header-block')
    {{ $article->title }}
@endcomponent

@component('components.organisms._o-artist-bio')
    @slot('item', $article)
    @slot('imageSettings', array(
        'srcset' => array(200,400,600,1000,1500,2000),
        'sizes' => aic_gridListingImageSizes(array(
              'xsmall' => '58',
              'small' => '58',
              'medium' => '58',
              'large' => '28',
              'xlarge' => '28',
        )),
    ))
@endcomponent

@component('components.molecules._m-title-bar')
    Artworks
@endcomponent

@if ($article->artworks)
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','true')
        @foreach ($article->artworks as $item)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' || $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' || $item->type !== 'artwork') ? '16:9' : null,
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

@if ($article->artworksMoreLink)
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(
            $article->artworksMoreLink
        ));
    @endcomponent
@endif

@if ($article->relatedArticles)
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
        @foreach ($article->relatedArticles as $item)
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

@if ($article->exploreFuther)
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', '')
        @slot('linksPrimary', $article->exploreFuther['nav'])
    @endcomponent
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('maintainOrder','false')
        @slot('moreLink',$article->exploreMoreLink)
        @foreach ($article->exploreFuther['items'] as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' || $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' || $item->type !== 'artwork') ? '16:9' : null,
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
        @endforeach
    @endcomponent
@endif

@if ($article->exhibitions)
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
        @foreach ($article->exhibitions as $item)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif


@component('components.organisms._o-recently-viewed')
    @slot('artworks',$article->recentlyViewedArtworks ?? null)
@endcomponent

@component('components.organisms._o-interested-themes')
    @slot('themes',$article->interestedThemes ?? null)
@endcomponent

@endsection
