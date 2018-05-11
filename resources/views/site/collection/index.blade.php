@extends('layouts.app')

@section('content')

<section class="o-collection-listing">

@component('components.molecules._m-header-block')
    The Collection
@endcomponent

@component('components.molecules._m-intro-block')
    {!! $page->art_intro !!}
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('linksPrimary', [
        ['label' => 'Artworks', 'href' => '#', 'active' => true],
        ['label' => 'Writings', 'href' => route('articles_publications')],
        ['label' => 'Resources', 'href' => route('collection.research_resources')]
    ])
@endcomponent

@component('components.molecules._m-search-bar')
    @slot('placeholder','Search by keyword, artist or reference')
    @slot('name', 'collection-search')
    @slot('value', request('q'))
    @slot('behaviors','autocomplete')
    @slot('dataAttributes','data-autocomplete-url="'. route('collection.autocomplete') .'"')
    @slot('action', route('collection'))
@endcomponent

{{-- Component extraction to have a clearer code --}}
{{-- 'components.molecules._m-quick-search-links----collection' --}}
@if (empty(request()->input()))
    <div class="m-quick-search-links">
        <ul class="m-quick-search-links__links" data-behavior="dragScroll">
        @foreach ($page->apiModels('artCategoryTerms', 'CategoryTerm') as $category)
            <li>
                @component('components.atoms._tag')
                    @slot('variation', 'tag--w-image')
                    @slot('href', $category->present()->collectionUrl)
                    @slot('dataAttributes',' data-ajax-scroll-target="collection"')
                    @component('components.atoms._img')
                        @slot('image', $category->imageFront('thumb', 'default'))
                        @slot('settings', array(
                            'fit' => 'crop',
                            'ratio' => '1:1',
                            'srcset' => array(20,40),
                            'sizes' => '40px',
                        ))
                    @endcomponent
                    {{ $category->title }}
                @endcomponent
            </li>
        @endforeach
        </ul>
    </div>
@endif

<a name="collection" id="collection"></a>

@component('components.molecules._m-search-actions----collection')
    @slot('onViewLink', route('collection', (request()->filled('is_on_view') ? [] : request()->input() + ['is_on_view' => true])))
    @slot('onViewActive', request()->filled('is_on_view'))

    @slot('total', $artworks->total())
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
        @slot('placeholder','Search...')
        @slot('name', 'collection-search')
        @slot('value', request('q'))
        @slot('action', route('collection'))
    @endcomponent
    <div class="o-collection-search__scroll-area">
        <p class="o-collection-search__title f-tag-2">Quick Search</p>
        <ul class="o-collection-search__quick-search-links">
            @foreach ($page->apiModels('artCategoryTerms', 'CategoryTerm') as $category)
                <li>
                    <a href="{!! $category->present()->collectionUrl !!}" class="tag tag--quinary f-tag">
                        {{ $category->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <p class="o-collection-search__close">
        <button class="btn btn--tertiary btn--full f-buttons" data-behavior="hideCollectionSearch">Close Search</button>
    </p>
</div>

@if ($artworks->hasMorePages())
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary', 'loadMoreUrl' => route('collection.more', request()->input()), 'loadMoreTarget' => '#artworksList')))
    @endcomponent
@endif


@if ($featuredArticles)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all articles', 'href' => '#')))
        Featured
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    <div class="o-feature-plus-4">
        @if ($featuredArticlesHero)
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
        @endif
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

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

</section>

@endsection
