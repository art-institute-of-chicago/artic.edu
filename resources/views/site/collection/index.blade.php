@extends('layouts.app')

@section('content')

<section class="o-collection-listing">

@component('components.molecules._m-header-block')
    The Collection
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $page->present()->art_intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('isPrimaryPageNav', true)
    @slot('linksPrimary', [
        ['label' => 'Artworks', 'href' => route('collection'), 'active' => true],
        ['label' => 'Writings', 'href' => route('articles_publications')],
        ['label' => 'Resources', 'href' => route('collection.research_resources')]
    ])
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('placeholder','Search by keyword, artist, or reference')
    @slot('name', 'collection-search')
    @slot('value', request('q'))
    @slot('behaviors','autocomplete')
    @slot('dataAttributes','data-autocomplete-url="'. secureRoute('collection.autocomplete') .'"')
    @slot('gtmAttributes', 'data-gtm-event="click" data-gtm-event-action="' . $seo->title .'" data-gtm-event-category="collection-search"')
    @slot('action', route('collection'))
@endcomponent

{{-- Component extraction to have a clearer code --}}
{{-- 'components.molecules._m-quick-search-links----collection' --}}
@if (empty(request()->input()))
    <div class="m-quick-search-links">
        <h3 class="sr-only" id="h-quick-search">Quick search options</h3>
        <ul class="m-quick-search-links__links" aria-labelledby="h-quick-search" data-behavior="dragScroll">
        @foreach ($page->apiModels('artCategoryTerms', 'CategoryTerm') as $category)
            <li>
                @component('components.atoms._tag')
                    @slot('href', $category->present()->collectionUrl)
                    @slot('dataAttributes',' data-ajax-scroll-target="collection"')
                    @if (!empty($category->imageFront('thumb', 'default')))
                        @slot('variation', 'tag--senary tag--w-image')
                        @component('components.atoms._img')
                            @slot('image', $category->imageFront('thumb', 'default'))
                            @slot('settings', array(
                                'fit' => 'crop',
                                'ratio' => '1:1',
                                'srcset' => array(20,40),
                                'sizes' => '40px',
                            ))
                        @endcomponent
                    @else
                        @slot('variation', 'tag--senary')
                    @endif
                    @slot('gtmAttributes', 'data-gtm-event="' . getUtf8Slug( $category->title ) . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="collection-quick-search"')
                    {!! $category->present()->title !!}
                @endcomponent
            </li>
        @endforeach
        </ul>
    </div>
@endif

<a name="collection" id="collection"></a>

@component('components.molecules._m-search-actions----collection')
    @slot('onViewLink', route('collection', (request()->filled('is_on_view') ? Arr::except(request()->input(), ['is_on_view']) : request()->input() + ['is_on_view' => true])))
    @slot('onViewActive', request()->filled('is_on_view'))
    @slot('hasAnyFilter', $hasAnyFilter)

    @slot('total', number_format($artworks->total()))
@endcomponent

<div class="o-collection-listing__colset">
    <div class="o-collection-listing__col-left">
        @component('components.organisms._o-collection-filters')
            @if (!empty($activeFilters))
                @slot('activeFilters', $activeFilters)
            @endif
            @slot('clearAllLink', route('collection'))
            @slot('filterCategories', $filterCategories)
        @endcomponent
    </div>
    <div class="o-collection-listing__col-right">
        @if (!empty($activeFilters))
            @component('components.molecules._m-active-filters')
                @slot('links', $activeFilters)
                @slot('clearAllLink', route('collection'))
            @endcomponent
        @endif
        @if ($artworks->count() > 0)
            @component('components.organisms._o-pinboard')
                @slot('id', 'artworksList')
                @slot('cols_xsmall','2')
                @slot('cols_small','2')
                @slot('cols_medium','3')
                @slot('cols_large','4')
                @slot('cols_xlarge','4')
                @slot('maintainOrder','false')
                @slot('optionLayout','o-pinboard--2-col@xsmall o-pinboard--2-col@small o-pinboard--2-col@medium o-pinboard--3-col@large o-pinboard--3-col@xlarge')
                @component('site.collection._items')
                    @slot('artworks', $artworks)
                @endcomponent
            @endcomponent
        @else
            @component('components.molecules._m-no-results')
            @endcomponent
        @endif
    </div>
</div>

@component('components.molecules._m-search-triggers----collection')
    @slot('filtersCount',isset($activeFilters) ? count($activeFilters) : 0)
@endcomponent

<div class="o-collection-search" data-behavior="collectionSearch">
    @component('components.molecules._m-search-bar')
        @slot('placeholder','Search…')
        @slot('name', 'collection-search')
        @slot('value', request('q'))
        @slot('action', route('collection'))
        @slot('behaviors','autocomplete')
        @slot('dataAttributes','data-autocomplete-url="'. secureRoute('collection.autocomplete') .'"')
        @slot('gtmAttributes', 'data-gtm-old-label="click" data-gtm-event-action="discover-art-artists" data-gtm-event-category="collection-search"')
    @endcomponent
    <div class="o-collection-search__scroll-area">
        <h3 class="o-collection-search__title f-tag-2" id="h-quick-search-mobile">Quick Search</h3>
        <ul class="o-collection-search__quick-search-links" aria-labelledby="h-quick-search-mobile">
            @foreach ($page->apiModels('artCategoryTerms', 'CategoryTerm') as $category)
                <li>
                    <a href="{!! $category->present()->collectionUrl !!}" class="tag tag--quinary f-tag" data-gtm-old-label="quick-search-click" data-gtm-event="{{ getUtf8Slug($category->title) }}"  data-gtm-action="discover-art-artists" data-gtm-event-category="collection-search">
                        {!! $category->present()->title !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <p class="o-collection-search__close">
        <button class="btn btn--tertiary btn--full f-buttons" data-behavior="hideCollectionSearch">Close Search</button>
    </p>
</div>

{{-- Keeping this "Load more" template around for reference --}}
@if (false)
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary', 'loadMoreUrl' => route('collection.more', request()->input(), false), 'loadMoreTarget' => '#artworksList', 'loadMoreLimitText' => 'If you\'re still having trouble finding what you\'re looking for, please email collections@artic.edu.')))
    @endcomponent
@endif

@if ($artworks->hasMorePages())
    {!! $artworks->appends(request()->input())->links() !!}
@endif


@if ($featuredItems)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all articles', 'href' => route('articles'))))
        Featured
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    <div class="o-feature-plus-4">
        @if ($featuredItemsHero)
        @component('components.molecules._m-listing----' . strtolower($featuredItemsHero->type))
            @slot('tag', 'div')
            @slot('titleFont', 'f-headline-editorial')
            @slot('captionFont', 'f-body-editorial')
            @slot('variation', 'o-feature-plus-4__feature')
            @slot('item', $featuredItemsHero)
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
            @slot('gtmAttributes', 'data-gtm-event="' . $featuredItemsHero->title . '" data-gtm-event-action="feature" data-gtm-event-category="collection-nav"')
        @endcomponent
        @endif
        <h3 class="sr-only" id="h-featured-plus-1">Featured articles</h3>
        <ul class="o-feature-plus-4__items-1" aria-labelledby="h-featured-plus-1">
        @foreach ($featuredItems as $item)
            @if ($loop->index < 2)
                @component('components.molecules._m-listing----' . strtolower($item->type) . '-minimal')
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
                    @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="collection-nav"')
                @endcomponent
            @endif
        @endforeach
        </ul>
        <h3 class="sr-only" id="h-featured-plus-2">More featured articles</h3>
        <ul class="o-feature-plus-4__items-2" aria-labelledby="h-featured-plus-2">
        @foreach ($featuredItems as $item)
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
                    @slot('gtmAttributes', 'data-gtm-event="{{$item->title}}" data-gtm-event-action="' . $seo->title . '" data-gtm-event-category="collection-nav"')
                @endcomponent
            @endif
        @endforeach
        </ul>
    </div>
@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

</section>

@endsection
