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
        <button class="f-secondary">
            <svg class="icon--search-24"><use xlink:href="#icon--close" /></svg>
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
        <button>
            <svg class="icon--search-24"><use xlink:href="#icon--close" /></svg>
            <span class="f-buttons">Filter (1)</span>
        </button>
    </li>
    <li>
        <button class="f-buttons">
            <svg class="icon--search-24"><use xlink:href="#icon--close" /></svg>
        </button>
    </li>
</ul>

<div class="o-search-form">
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
</div>

<div class="o-search-filters">
    <div class="m-active-filters o-search-filters__active-filters">
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


    <div class="o-accordion o-search-filters__filters" role="tablist" multiselectable="true" data-behavior="accordion">

        <p id="filters_trigger_01" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_01" aria-expanded="true" role="tab" tabindex="0">
            With search
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_01" class="o-accordion__panel" aria-labelledby="filters_trigger_01" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content">
                <form>
                    <label>Find Location</label>
                    <input placeholder="Find location">
                    <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
                </form>
                <ul>
                    <li>
                        <a href="#" class="checkbox f-secondary">Africa <i>(5156)</i></a>
                    </li>
                    <li>
                        <a href="#" class="checkbox f-secondary">Asia <i>(5156)</i></a>
                    </li>
                    <li>
                        <a href="#" class="checkbox f-secondary">Europe <i>(5156)</i></a>
                    </li>
                    <li>
                        <a href="#" class="checkbox f-secondary">Roman Empire <i>(5156)</i></a>
                    </li>
                    <li>
                        <a href="#" class="checkbox f-secondary">United States <i>(5156)</i></a>
                    </li>
                </ul>
            </div>
        </div>

        <p id="filters_trigger_02" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_02" aria-expanded="true" role="tab" tabindex="0">
            With show more
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_02" class="o-accordion__panel" aria-labelledby="filters_trigger_02" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content">
                <ul class="s-capped">
                    <?php for ($i = 0; $i < 20; $i++): ?>
                    <li>
                        <a href="#" class="checkbox f-secondary">Lorem <i>(1312)</i></a>
                    </li>
                    <?php endfor; ?>
                </ul>
                <button class="f-secondary">Show more</button>
            </div>
        </div>

        <p id="filters_trigger_03" class="o-accordion__trigger f-tag-2" aria-selected="true" aria-controls="filters_03" aria-expanded="true" role="tab" tabindex="0">
            With range slider
            <svg class="icon--plus"><use xlink:href="#icon--plus" /></svg>
            <svg class="icon--minus"><use xlink:href="#icon--minus" /></svg>
        </p>
        <div id="filters_03" class="o-accordion__panel" aria-labelledby="filters_trigger_03" aria-hidden="false" role="tabpanel">
            <div class="o-accordion__panel-content">
                <div class="range-slider" data-behavior="rangeSlider" data-param="price">
                  <em class="range-slider__display">
                    <span data-min-val-target></span> - <span data-max-val-target></span>
                  </em>
                  <div class="range-slider__slider">
                    <span class="range-slider__range"></span>
                    <span class="range-slider__thumb thumb--min" data-thumb="min"></span>
                    <span class="range-slider__thumb thumb--max" data-thumb="max"></span>
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
            <div class="o-accordion__panel-content">
                <ul>
                    <?php for ($i = 0; $i < 4; $i++): ?>
                    <li>
                        <a href="#" class="checkbox f-secondary">Lorem <i>(1312)</i></a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>

    </div>


    <p class="o-search-filters__close">
        <button>Close Filters</button>
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
