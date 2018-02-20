@extends('layouts.app')

@section('content')

<article class="o-article">

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->present()->headerType)
    @slot('title', $item->title)
    @slot('date', $item->date)
    @slot('dateStart', $item->dateStart)
    @slot('dateEnd', $item->dateEnd)
    @slot('type', $item->present()->type)
    @slot('intro', $item->hero_caption)
    @slot('img', $item->imageAsArray('hero'))
    {{-- @slot('galleryImages', $item->galleryImages) --}}
    {{-- @slot('nextArticle', $item->nextArticle) --}}
    {{-- @slot('prevArticle', $item->prevArticle) --}}
  @endcomponent

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}">

    @component('components.molecules._m-article-actions')
        @slot('articleType', 'event')
    @endcomponent

    @if ($item->nav)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $item->nav);
        @endcomponent
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  @if ($item->nav)
  <div class="o-article__meta">
    @if ($item->nav)
        @component('components.molecules._m-link-list')
            @slot('links', $item->nav);
        @endcomponent
    @endif
  </div>
  @endif

  <div class="o-article__secondary-actions">
    @component('components.molecules._m-ticket-actions----event')
        @slot('ticketPrices', $item->ticketPrices);
        @slot('ticketLink', $item->ticketLink);
    @endcomponent

    @if ($item->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $item->featuredRelated['type'])
          @slot('items', $item->featuredRelated['items'])
          @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
      @endcomponent
    @endif
  </div>

  @if ($item->hero_caption and $item->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $item->hero_caption }}
    @endcomponent
  </div>
  @endif

  @if ($item->featuredRelated)
  {{-- dupe 😢 - hidden medium+ --}}
  <div class="o-article__related">
    @component('components.blocks._inline-aside')
        @slot('type', $item->featuredRelated['type'])
        @slot('items', $item->featuredRelated['items'])
        @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks" data-behavior="articleBodyInViewport">
    @component('components.blocks._blocks')
        @slot('editorial', false)
        @slot('blocks', $item->blocks ?? null)
        @slot('dropCapFirstPara', false)
    @endcomponent

    @if ($item->pictures)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Picture{{ sizeof($item->pictures) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($item->pictures as $picture)
            @component('components.molecules._m-media')
                @slot('variation', 'o-blocks__block')
                @slot('item', $picture)
            @endcomponent
        @endforeach
    @endif

    @if ($item->speakers)
        @component('components.blocks._text')
            @slot('font', 'f-module-title-2')
            @slot('tag', 'h4')
            Speaker{{ sizeof($item->speakers) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($item->speakers as $speaker)
            @component('components.molecules._m-row-block')
                @slot('variation', 'm-row-block--inline-title m-row-block--keyline-top')
                @slot('title', $speaker['title'] ?? null)
                @slot('img', $speaker['img'] ?? null)
                @slot('text', $speaker['text'] ?? null)
                @slot('titleFont', 'f-subheading-1')
                @slot('textFont', ($item->articleType === 'editorial') ? 'f-body-editorial' : 'f-body')
            @endcomponent
        @endforeach
    @endif

    @if ($item->sponsors)
        @component('components.blocks._text')
            @slot('font', 'f-module-title-2')
            @slot('tag', 'h4')
            Sponsors
        @endcomponent
        @component('components.blocks._blocks')
            @slot('editorial', ($item->articleType === 'editorial'))
            @slot('blocks', $item->sponsors ?? null)
        @endcomponent
    @endif

    @if ($item->futherSupport)
        @component('components.molecules._m-row-block')
            @slot('variation', 'm-row-block--keyline-top o-blocks__block')
            @slot('title', $item->futherSupport['title'] ?? null)
            @slot('img', $item->futherSupport['logo'] ?? null)
            @slot('text', $item->futherSupport['text'] ?? null)
        @endcomponent
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', 'event')
    @endcomponent
  </div>

  <a class="o-article__top-link" href="#a17">
    <svg class="icon--arrow" aria-label="top of page">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow">
    </svg>
  </a>

</article>

@if (isset($relatedEventsByDay))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => '#')))
        @slot('id', 'related_events')
        Related Events
    @endcomponent
    @component('components.organisms._o-row-listing')
        @foreach ($relatedEventsByDay as $date => $events)
            @component('components.molecules._m-date-listing')
                @slot('date', $date)
                @slot('events', $events)
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary')))
    @endcomponent
@endif

@if ($item->relatedExhibitions)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all exhibitions', 'href' => '#')))
        {{ $item->relatedExhibitionsTitle ? $item->relatedExhibitionsTitle : "Related Exhibitions" }}
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($item->relatedExhibitions as $item)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($item->relatedEvents)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => '#')))
        Related Events
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($item->relatedEvents as $item)
            @component('components.molecules._m-listing----event')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($item->relatedArticles)
    @component('components.molecules._m-title-bar')
        Further Reading
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($item->relatedArticles as $item)
            @component('components.molecules._m-listing----article')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@endsection
