@extends('layouts.app')

@section('content')

<section class="o-collection-listing">

@component('components.molecules._m-header-block')
    {{ $title }}
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('linksPrimary', array(array('label' => 'Artworks', 'href' => '#', 'active' => true), array('label' => 'Articles &amp; Publications', 'href' => '#'), array('label' => 'Research', 'href' => '#')))
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('placeholder','Search by keyword, artist or reference')
    @slot('name', 'collection-search')
    @slot('behaviors','autocomplete')
    @slot('dataAttributes','data-autocomplete-url="/collections/search/"')
    @slot('action','/statics/collection')
@endcomponent

@component('components.molecules._m-quick-search-links----collection')
    @slot('links', $quickSearchLinks)
@endcomponent

@component('components.molecules._m-search-actions----collection')
@endcomponent

@if (!empty($activeFilters))
    @component('components.molecules._m-active-filters')
        @slot('links', $activeFilters)
        @slot('clearAllLink', '/statics/collection')
    @endcomponent
@endif

@component('components.molecules._m-search-triggers----collection')
@endcomponent

@component('components.organisms._o-collection-search')
    @slot('links', $quickSearchLinks)
@endcomponent

@component('components.organisms._o-collection-filters')
    @if (!empty($activeFilters))
        @slot('activeFilters', $activeFilters)
    @endif
    @slot('clearAllLink', '/statics/collection')
    @slot('filterCategories', $filterCategories)
@endcomponent

@if (!empty($activeFilters))
    @component('components.organisms._o-pinboard')
        @slot('cols_xsmall','2')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','false')
        @foreach ($artworks as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                    'srcset' => array(200,400,600,1000),
                    'sizes' => aic_gridListingImageSizes(array(
                          'xsmall' => '2',
                          'small' => '2',
                          'medium' => '3',
                          'large' => '3',
                          'xlarge' => '4',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@else
    @component('components.molecules._m-no-results')
    @endcomponent
@endif


@if (!empty($featuredArticles))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all articles', 'href' => '#')))
        Featured
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    <div class="o-feature-plus-4">
        @component('components.molecules._m-listing----article')
            @slot('tag', 'p')
            @slot('titleFont', 'f-list-5')
            @slot('captionFont', 'f-body-editorial')
            @slot('variation', 'o-feature-plus-4__feature')
            @slot('item', $featuredArticlesHero)
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '58',
                      'medium' => '38',
                      'large' => '28',
                      'xlarge' => '28',
                )),
            ))
        @endcomponent
        <ul class="o-feature-plus-4__items-1">
        @foreach ($featuredArticles as $item)
            @if ($loop->index < 2)
                @component('components.molecules._m-listing----article-minimal')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '28',
                              'medium' => '18',
                              'large' => '13',
                              'xlarge' => '13',
                        )),
                    ))
                @endcomponent
            @endif
        @endforeach
        </ul>
        <ul class="o-feature-plus-4__items-2">
        @foreach ($featuredArticles as $item)
            @if ($loop->index > 1)
                @component('components.molecules._m-listing----article-minimal')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(200,400,600),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '28',
                              'medium' => '18',
                              'large' => '13',
                              'xlarge' => '13',
                        )),
                    ))
                @endcomponent
            @endif
        @endforeach
        </ul>
    </div>
@endif

@component('components.organisms._o-recently-viewed')
    @slot('artworks',$recentlyViewedArtworks ?? null)
@endcomponent

@component('components.organisms._o-interested-themes')
    @slot('themes',$interestedThemes ?? null)
@endcomponent

</section>

@endsection
