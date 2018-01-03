@extends('layouts.app')

@section('content')

<article class="o-article">

  @component('components.molecules._m-article-header')
    @slot('headerType', ($article->headerType ?? null))
    @slot('variation', 'o-article__header')
    @slot('title', $article->title)
    @slot('date', $article->date)
    @slot('type', $article->type)
    @slot('intro', $article->intro)
    @slot('img', $article->headerImage)
  @endcomponent

  <div class="o-article__primary">

    @component('components.molecules._m-article-actions')
    @endcomponent

    @if ($article->nav)
        @component('components.molecules._m-link-list')
            @slot('links', $article->nav);
        @endcomponent
    @endif
  </div>

  <div class="o-article__secondary">

    @if ($article->articleType === 'exhibition')
        @component('components.molecules._m-ticket-actions----exhibition')
        @endcomponent
    @endif

    @if ($article->featuredRelated)
        @component('components.blocks._inline-aside')
            @slot('variation', 'u-show@xlarge+')
            @slot('type', $article->featuredRelated['type'])
            @slot('items', $article->featuredRelated['items'])
            @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
        @endcomponent
    @endif

  </div>

  @if ($article->featuredRelated)
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@small')
          @slot('type', $article->featuredRelated['type'])
          @slot('items', $article->featuredRelated['items'])
          @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
      @endcomponent
  @endif

  <div class="o-article__body" data-behavior="articleBodyInViewport">

    @component('components.blocks._blocks')
        @slot('blocks', $article->blocks)
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
    @endcomponent
  </div>

  <div class="o-article__tertiary u-show@medium+">

    @if ($article->featuredRelated)
        @component('components.blocks._inline-aside')
            @slot('type', $article->featuredRelated['type'])
            @slot('items', $article->featuredRelated['items'])
            @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
        @endcomponent
    @endif

  </div>

  @component('components.atoms._btn')
      @slot('variation', 'btn--icon arrow-link--up o-article__top-link')
      @slot('font', '')
      @slot('icon', 'icon--arrow')
      @slot('behavior', 'topLink')
      @slot('tag', 'a')
      @slot('href', '#a17')
  @endcomponent

</article>

@if ($article->relatedEventsByDay)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('text' => 'See all events', 'href' => '#')))
        Related Events
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($article->relatedEventsByDay as $date)
            @component('components.molecules._m-date-listing')
                @slot('date', $date)
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('text' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary')))
    @endcomponent
@endif

@if ($article->relatedExhibitions)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('text' => 'See all exhibitions', 'href' => '#')))
        Related Exhibitions
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('cols_xxlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedExhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@endsection
