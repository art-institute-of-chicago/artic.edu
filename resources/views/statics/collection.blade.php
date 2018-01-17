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
    @slot('linksPrimary', array(array('label' => 'Artworks', 'href' => '#', 'active' => true), array('label' => 'Articles &amp; Publications', 'href' => '#'), array('label' => 'Research', 'href' => '#')))
@endcomponent

<form>
    <label for="search">Search</label>
    <input name="search" placeholder="Search by keyword, artist or reference">
    <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
</form>

<ul class="m-quick-search-links">
@foreach ($quickSearchLinks as $filter)
    <li>
        <a href="{{ $filter['href'] }}" class="f-tag-2">
            @component('components.atoms._img')
                @slot('src', $filter['image']['src'])
                @slot('width', $filter['image']['width'])
                @slot('height', $filter['image']['height'])
            @endcomponent
            {{ $filter['label'] }}
        </a>
    </li>
@endforeach
</ul>

<ul class="m-search-actions">
    <li>
        <button class="f-secondary" data-behavior="showCollectionFilters">
            <svg class="icon--filter--24"><use xlink:href="#icon--filter--24" /></svg>
            Show Filters
        </button>
    </li>
    <li>
        <a href="#" class="checkbox f-secondary">
            On view
        </a>
    </li>
    <li>
        <span class="f-secondary">108,789 results</span>
    </li>
</ul>

<div class="m-active-filters">
    <ul class="m-active-filters__items">
    @foreach ($activeFilters as $filter)
        <li class="m-active-filters__item">
            <a href="{{ $filter['href'] }}" class="tag tag--quaternary f-tag">
                {{ $filter['label'] }}
                <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
            </a>
        </li>
    @endforeach
    </ul>
    <p class="m-active-filters__clear">
        <a href="#" class="f-buttons">Clear All</a>
    </p>
</div>

<ul class="m-search-triggers">
    <li>
        <button data-behavior="showCollectionFilters">
            <svg class="icon--filter--24"><use xlink:href="#icon--filter--24" /></svg>
            <span class="f-buttons">Filter (1)</span>
        </button>
    </li>
    <li>
        <button class="f-buttons" data-behavior="showCollectionSearch">
            <svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
        </button>
    </li>
</ul>

<div class="o-collection-search" data-behavior="collectionSearch">
    <form>
        <label for="search">Search</label>
        <input name="search" placeholder="Search by keyword, artist or reference">
        <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
    </form>
    <p class="f-tag-2">Quick Search</p>
    <ul class="m-quick-search-links">
    @foreach ($quickSearchLinks as $filter)
        <li>
            <a href="{{ $filter['href'] }}" class="f-tag-2">
                {{ $filter['label'] }}
            </a>
        </li>
    @endforeach
    </ul>
    <p class="o-collection-search__close">
        <button data-behavior="hideCollectionSearch">Close Search</button>
    </p>
</div>

<div class="o-collection-filters" data-behavior="collectionFilters">
    <div class="m-active-filters o-collection-filters__active-filters">
        <ul class="m-active-filters__items">
        @foreach ($activeFilters as $filter)
            <li class="m-active-filters__item">
                <a href="{{ $filter['href'] }}" class="tag tag--quaternary f-tag">
                    {{ $filter['label'] }}
                    <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
                </a>
            </li>
        @endforeach
        </ul>
        <p class="m-active-filters__clear">
            <a href="#" class="f-buttons">Clear All</a>
        </p>
    </div>


    <div class="o-accordion o-accordion--filters o-collection-filters__filters" role="tablist" multiselectable="true" data-behavior="accordion">

        <p id="filters_trigger_01" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_01" aria-expanded="true" role="tab" tabindex="0">
            With search
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_01" class="o-accordion__panel" aria-labelledby="filters_trigger_01" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content m-filters">
                <form class="m-filters__whittle-down" data-behavior="filterWhittleDown">
                    <label>Find Location</label>
                    <input type="text" class="f-secondary" placeholder="Find location">
                    <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
                </form>
                <ul class="m-filters__list">
                    @foreach ($filters as $filter)
                    <li>
                        <a href="{{ $filter['href'] }}" class="checkbox f-secondary">{{ $filter['label'] }} <em>({{ $filter['count'] }})</em></a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <p id="filters_trigger_02" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_02" aria-expanded="true" role="tab" tabindex="0">
            With show more
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_02" class="o-accordion__panel" aria-labelledby="filters_trigger_02" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content m-filters">
                <ul class="m-filters__list s-capped">
                    @foreach ($filters as $filter)
                    <li>
                        <a href="{{ $filter['href'] }}" class="checkbox f-secondary">{{ $filter['label'] }} <em>({{ $filter['count'] }})</em></a>
                    </li>
                    @endforeach
                </ul>
                <button class="m-filters__show-more-toggle f-secondary" data-behavior="filterToggleShowMore">
                    <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                    <span>Show more</span>
                </button>
            </div>
        </div>

        <p id="filters_trigger_03" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_03" aria-expanded="true" role="tab" tabindex="0">
            With range slider
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_03" class="o-accordion__panel" aria-labelledby="filters_trigger_03" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content">
                <script>
                var dateRangeValues = ['8000BC','7000BC','6000BC','5000BC','4000BC','3000BC','2000BC','1000BC','1AD','500AD','1000AD','1200AD','1400AD','1600AD','1700AD','1800AD','1900AD','1910AD','1920AD','1930AD','1940AD','1950AD','1960AD','1970AD','1980AD','1990AD','2000AD','2010AD','Present'];
                </script>
                <div class="range-slider" data-behavior="rangeSlider" data-param="date" data-range-values="dateRangeValues">
                  <em class="range-slider__display f-secondary">
                    <span data-range-min-display></span> - <span data-range-max-display></span>
                  </em>
                  <div class="range-slider__slider" data-range-slider>
                    <span class="range-slider__range" data-range-bar></span>
                    <span class="range-slider__thumb range-slider__thumb--min" data-range-thumb-min></span>
                    <span class="range-slider__thumb range-slider__thumb--max" data-range-thumb-max></span>
                  </div>
                </div>
            </div>
        </div>

        <p id="filters_trigger_04" class="o-accordion__trigger f-tag-2" aria-selected="false" aria-controls="filters_04" aria-expanded="false" role="tab" tabindex="0">
            Hidden
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_04" class="o-accordion__panel" aria-labelledby="filters_trigger_04" aria-hidden="true" role="tabpanel">
            <div class="o-accordion__panel-content m-filters">
                <ul class="m-filters__list">
                    <?php for ($i = 0; $i < 4; $i++): ?>
                    <li>
                        <a href="#" class="checkbox f-secondary">Lorem <em>(1312)</em></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>

    </div>

    <p class="o-collection-filters__close">
        <button data-behavior="hideCollectionFilters">Close Filters</button>
    </p>
</div>

@component('components.organisms._o-pinboard')
    @slot('cols_xsmall','2')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','4')
    @slot('cols_xxlarge','4')
    @slot('maintainOrder','false')
    @foreach ($artworks as $item)
        @component('components.molecules._m-listing----'.$item->type)
            @slot('variation', 'o-pinboard__item')
            @slot($item->type, $item)
        @endcomponent
    @endforeach
@endcomponent


@if ($featuredArticles)
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
            @slot('article', $featuredArticlesHero)
        @endcomponent
        <ul class="o-feature-plus-4__items-1">
        @foreach ($featuredArticles as $editorial)
            @if ($loop->index < 2)
                @component('components.molecules._m-listing----article-minimal')
                    @slot('article', $editorial)
                @endcomponent
            @endif
        @endforeach
        </ul>
        <ul class="o-feature-plus-4__items-2">
        @foreach ($featuredArticles as $editorial)
            @if ($loop->index > 1)
                @component('components.molecules._m-listing----article-minimal')
                    @slot('article', $editorial)
                @endcomponent
            @endif
        @endforeach
        </ul>
    </div>
@endif

@if ($recentlyViewedArtworks)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'Clear your history', 'href' => '#')))
        Recently Viewed
    @endcomponent
    @component('components.atoms._hr')
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--scroll@medium o-grid-listing--scroll@large o-grid-listing--scroll@xlarge o-grid-listing--scroll@xxlarge o-grid-listing--gridlines-cols')
        @slot('cols_large',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('cols_xlarge',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('cols_xxlarge',(sizeof($recentlyViewedArtworks) > 6) ? '12' : '6')
        @slot('behavior','dragScroll')
        @foreach ($recentlyViewedArtworks as $artwork)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('artwork', $artwork)
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.atoms._hr')
        @slot('variation','hr--flush-topp')
    @endcomponent
@endif

@if ($interestedThemes)
    @php
        $themeString = 'It seems it you could also be interested in ';
        $themesLength = sizeof($interestedThemes);
        $themesIndex = 1;
        foreach ($interestedThemes as $theme) {
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
