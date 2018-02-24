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


@if ($article->recentlyViewedArtworks)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Clear your history', 'href' => '#')))
        Recently Viewed
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge  o-grid-listing--gridlines-cols')
        @slot('cols_large',(sizeof($article->recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('cols_xlarge',(sizeof($article->recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('behavior','dragScroll')
        @foreach ($article->recentlyViewedArtworks as $item)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'srcset' => array(108,216,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '216px',
                          'large' => sizeof($article->recentlyViewedArtworks) > 6 ? 3 : 8,
                          'xlarge' => sizeof($article->recentlyViewedArtworks) > 6 ? 3 : 8,
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-topp')
    @endcomponent
@endif

@if ($article->interestedThemes)
    @php
        $themeString = 'It seems it you could also be interested in ';
        $themesLength = sizeof($article->interestedThemes);
        $themesIndex = 1;
        foreach ($article->interestedThemes as $theme) {
            if ($themesIndex > 1 && $themesIndex < $themesLength) {
                $themeString .= ', ';
            }
            if ($themesIndex === $themesLength) {
                $themeString .= ' and ';
            }
            $themeString .= '<a href="'.$theme['href'].'">'.$theme['label'].'</a>';
            if ($themesIndex === $themesLength) {
                $themeString .= '.';
            }
            $themesIndex++;
        }
    @endphp
    @component('components.blocks._text')
        @slot('variation','interests-list')
        @slot('font','f-list-2')
        @slot('tag','p')
        {!! $themeString !!}
    @endcomponent
@endif

@endsection
