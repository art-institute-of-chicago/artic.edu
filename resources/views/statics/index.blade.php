@extends('layouts.app')

@section('content')

<article class="o-article o-article--generic-page">
    @component('components.molecules._m-article-header')
      @slot('headerType', 'generic')
      @slot('variation', 'o-article__header')
      @slot('title', 'Statics Index')
    @endcomponent

    <div class="o-article__primary-actions o-blocks">
        <h4 class="title f-subheading-1">From specs</h4>
        <ul class="list f-body">
          <li><a href="/statics/typespec">typespec</a></li>
          <li><a href="/statics/icons">icons</a></li>
          <li><a href="/statics/listings">listings</a></li>
        </ul>
        <h4 class="title f-subheading-1">Utility</h4>
        <ul class="list f-body">
          <li><a href="/statics/typetest">typetest</a></li>
          <li><a href="/statics/listinggrids">variants of o-grid-listing</a></li>
          <li><a href="/statics/toybox">toy box</a></li>
        </ul>
    </div>
    <div class="o-article__body o-blocks">
        <h4 class="title f-subheading-1">Batch 01</h4>
        <ul class="list f-body">
          <li>
            <a href="/statics/home">home</a>
            <ul class="list">
              <li><a href="/statics/home_1_feature">home 1 feature</a></li>
              <li><a href="/statics/home_features">home mixed features</a></li>
              <li><a href="/statics/home_videos">home videos</a></li>
            </ul>
          </li>
          <li><a href="/statics/exhibitions_and_events">exhibitions and events</a></li>
          <li>
            <a href="/statics/events">events</a>
            <ul class="list">
              <li><a href="/statics/events_no_results">events no results</a></li>
            </ul>
          </li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/article">all blocks, standard header</a></li>
          <li><a href="/statics/article_feature">all blocks, feature header</a></li>
          <li><a href="/statics/article_hero">all blocks, hero header</a></li>
          <li><a href="/statics/article_superhero">all blocks, super hero header</a></li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/article_cms_blocks">cms blocks, standard header</a></li>
          <li><a href="/statics/article_galleries">galleries</a></li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/generic_landing">generic landing</a></li>
          <li><a href="/statics/generic_detail">generic detail</a></li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/exhibition">exhibition, super hero header</a></li>
          <li><a href="/statics/event">event, standard header</a></li>
          <li><a href="/statics/event_feature">event, feature header</a></li>
          <li><a href="/statics/event_hero">event, hero header</a></li>
          <li><a href="/statics/event_superhero">event, super hero header</a></li>
          <li><a href="/statics/event_past">event past, standard header</a></li>
          <li><a href="/statics/editorial">editorial, feature header</a></li>
        </ul>
        <h4 class="title f-subheading-1">Batch 02</h4>
        <ul class="list f-body">
          <li><a href="/statics/artwork">artwork, images header</a></li>
          <li>
            <a href="/statics/collection">collection</a>
            <ul class="list">
                <a href="/statics/collection_no_results">collection no results</a>
            </ul>
          </li>
          <li>
            <a href="/statics/visit">visit</a>
            <ul class="list">
                <li><a href="/statics/visit_video">visit video</a></li>
            </ul>
          </li>
        </ul>
        <h4 class="title f-subheading-1">Batch 03</h4>
        <ul class="list f-body">
          <li>
            <a href="/statics/exhibition_history">exhibition history</a>
            <ul class="list">
                <li><a href="/statics/exhibition_history_no_results">exhibition history no results</a></li>
            </ul>
          </li>
          <li><a href="/statics/exhibition_history_detail">exhibition history details</a></li>
          <li>
            <a href="/statics/generic_listing">generic listing</a>
            <ul class="list">
                <li><a href="/statics/generic_listing_no_results">generic listing no results</a></li>
            </ul>
          </li>
          <li><a href="/statics/faq">faq</a></li>
          <li><a href="/statics/artist_tag">artist tag</a></li>
          <li><a href="/statics/artist_tag_no_intro">artist tag no intro</a></li>
          <li><a href="/statics/research_landing">research landing</a></li>
        </ul>
        <h4 class="title f-subheading-1">Batch 04</h4>
        <ul class="list f-body">
          <li><a href="/statics/articles_publications_landing">articles publications landing</a></li>
          <li><a href="/statics/articles">articles</a></li>
          <li><a href="/statics/generic_form">generic form</a></li>
          <li><a href="/statics/contact">contact</a></li>
          <li>
            <a href="/statics/search_results">search results</a>
            <ul class="list">
                <li><a href="/statics/search_results_no_results">search no results</a></li>
                <li><a href="/statics/search_results_artists">search results artists</a></li>
                <li><a href="/statics/search_results_pages">search results pages</a></li>
                <li><a href="/statics/search_results_artworks">search results artworks</a></li>
                <li><a href="/statics/search_results_events_and_exhibitions">search results events and exhibitions</a></li>
                <li><a href="/statics/search_results_articles_and_publications">search results articles and publications</a></li>
                <li><a href="/statics/search_results_research_and_resources">search results research and resources</a></li>
            </ul>
          </li>
          <li>
              Roadblocks
              <ul class="list">
                  <li><a href="/statics/roadblock1">roadblock</a></li>
                  <li><a href="/statics/roadblock2">roadblock with image</a></li>
              </ul>
          </li>
          <li><a href="/statics/video">video detail</a></li>
        </ul>
    </div>
</article>

@endsection
