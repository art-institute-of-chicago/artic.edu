@extends('layouts.app')

@section('content')

<article class="o-article o-article--generic-page">
    @component('components.molecules._m-article-header')
      @slot('headerType', 'generic')
      @slot('variation', 'o-article__header')
      @slot('title', 'Statics Index')
    @endcomponent

    <div class="o-article__primary-actions o-blocks">
        <h4 class="title f-subheading-1">Utility</h4>
        <ul class="list f-body">
          <li><a href="/statics/typespec">typespec</a></li>
          <li><a href="/statics/typetest">typetest</a></li>
          <li><a href="/statics/icons">icons</a></li>
          <li><a href="/statics/listinggrids">listinggrids</a></li>
          <li><a href="/statics/listings">listings</a></li>
          <li><a href="/statics/toybox">toybox</a></li>
        </ul>
    </div>
    <div class="o-article__body o-blocks">
        <h4 class="title f-subheading-1">Batch 01</h4>
        <ul class="list f-body">
          <li><a href="/statics/home">home</a></li>
          <li><a href="/statics/exhibitions_and_events">exhibitions and events</a></li>
          <li><a href="/statics/events">events</a></li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/article">all blocks, standard header</a></li>
          <li><a href="/statics/article_feature">all blocks, feature header</a></li>
          <li><a href="/statics/article_hero">all blocks, hero header</a></li>
          <li><a href="/statics/article_superhero">all blocks, super hero header</a></li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/generic_landing">generic landing</a></li>
          <li><a href="/statics/generic_detail">generic detail</a></li>
        </ul>
        <ul class="list f-body">
          <li><a href="/statics/exhibition">exhibition, super hero header</a></li>
          <li><a href="/statics/event">event, standard header</a></li>
          <li><a href="/statics/editorial">editorial, feature header</a></li>
        </ul>
        <h4 class="title f-subheading-1">Batch 02</h4>
        <ul class="list f-body">
          <li><a href="/statics/artwork">artwork, images header</a></li>
          <li><a href="/statics/collection">collection</a></li>
          <li><a href="/statics/visit">visit</a></li>
        </ul>
        <h4 class="title f-subheading-1">Batch 03</h4>
        <ul class="list f-body">
          <li><a href="/statics/exhibition_history">exhibition history</a></li>
          <li><a href="/statics/exhibition_history_detail">exhibition history details</a></li>
          <li><a href="/statics/generic_listing">generic listing</a></li>
          <li><a href="/statics/faq">faq</a></li>
          <li><a href="/statics/artist_tag">artist tag</a></li>
          <li><a href="/statics/artist_tag_no_intro">artist tag no intro</a></li>
        </ul>
        <h4 class="title f-subheading-1">Batch 04</h4>
        <ul class="list f-body">
          <li><a href="/statics/research_landing">research landing</a></li>
          <li><a href="/statics/articles_publications_landing">articles publications landing</a></li>
          <li><a href="/statics/articles">articles</a></li>
          <li><a href="/statics/generic_form">generic form</a></li>
          <li><a href="/statics/contact">contact</a></li>
        </ul>
    </div>
</article>

@endsection
