@extends('layouts.app')

@section('content')

<article class="o-article{{ ($article->articleType === 'editorial') ? ' o-article--editorial' : '' }}" data-behavior="internalLinksScroll">

  @component('components.molecules._m-article-header')
    @slot('editorial', ($article->articleType === 'editorial'))
    @slot('headerType', ($article->headerType ?? null))
    @slot('variation', ($article->headerVariation ?? null))
    @slot('title', $article->title)
    @slot('date', $article->date)
    @slot('type', $article->type)
    @slot('intro', $article->intro)
    @slot('img', $article->headerImage)
    @slot('galleryImages', $article->galleryImages)
    @slot('nextArticle', $article->nextArticle)
    @slot('prevArticle', $article->prevArticle)
  @endcomponent

  <div class="o-article__primary-actions{{ ($article->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}{{ ($article->articleType === 'artwork') ? ' u-show@large+' : '' }}">
    @if ($article->articleType !== 'artwork')
        @component('components.molecules._m-article-actions')
            @slot('articleType', $article->articleType)
        @endcomponent
    @endif

    @if ($article->author)
        @component('components.molecules._m-author')
            @slot('variation', 'm-author---keyline-top')
            @slot('editorial', ($article->articleType === 'editorial'))
            @slot('img', $article->author['img'] ?? null);
            @slot('name', $article->author['name'] ?? null);
            @slot('link', $article->author['link'] ?? null);
            @slot('date', $article->date ?? null);
        @endcomponent
    @endif

    @if ($article->nav)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $article->nav);
        @endcomponent
    @endif

    @if ($article->onView)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.atoms._title')
            @slot('variation', 'u-show@large+')
            @slot('tag','p')
            @slot('font', 'f-module-title-1')
            On View
        @endcomponent
        @component('components.blocks._text')
            @slot('variation', 'u-show@large+')
            @slot('tag','p')
            @slot('font', 'f-secondary')
            <a href="{{ $article->onView['href'] }}">{{ $article->onView['label'] }}</a>
        @endcomponent
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  @if ($article->nav)
  <div class="o-article__meta">
    @if ($article->nav)
        @component('components.molecules._m-link-list')
            @slot('links', $article->nav);
        @endcomponent
    @endif
  </div>
  @endif

  <div class="o-article__secondary-actions{{ ($article->headerType === 'gallery') ? ' o-article__secondary-actions--inline-header' : '' }}{{ ($article->articleType === 'artwork') ? ' u-show@medium+' : '' }}">
    @if ($article->articleType === 'exhibition')
        @component('components.molecules._m-ticket-actions----exhibition')
        @endcomponent
    @endif

    @if ($article->articleType === 'event')
        @component('components.molecules._m-ticket-actions----event')
            @slot('ticketPrices', $article->ticketPrices);
            @slot('ticketLink', $article->ticketLink);
        @endcomponent
    @endif

    @if ($article->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $article->featuredRelated['type'])
          @slot('items', $article->featuredRelated['items'])
          @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
      @endcomponent
    @endif
  </div>

  @if ($article->headerType === 'gallery')
  <div class="o-article__inline-header">
    @if ($article->title)
      @component('components.atoms._title')
          @slot('tag','h1')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          {{ $article->title }}
      @endcomponent
    @endif
    @if ($article->subtitle)
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-subtitle')
          {{ $article->subtitle }}
      @endcomponent
    @endif
  </div>
  @endif

  @if ($article->intro and $article->headerType !== 'hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $article->intro }}
    @endcomponent
  </div>
  @endif

  @if ($article->featuredRelated)
  {{-- dupe 😢 - hidden medium+ --}}
  <div class="o-article__related">
    @component('components.blocks._inline-aside')
        @slot('type', $article->featuredRelated['type'])
        @slot('items', $article->featuredRelated['items'])
        @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks" data-behavior="articleBodyInViewport">
    @component('components.blocks._blocks')
        @slot('editorial', ($article->articleType === 'editorial'))
        @slot('blocks', $article->blocks ?? null)
        @slot('dropCapFirstPara', ($article->articleType === 'editorial'))
    @endcomponent

    @if ($article->catalogues)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Catalogue{{ sizeof($article->catalogues) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($article->catalogues as $catalogue)
            @component('components.molecules._m-download-file')
                @slot('file', $catalogue)
            @endcomponent
        @endforeach
    @endif

    @if ($article->otherResources)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Other Resource{{ sizeof($article->otherResources) > 1 ? 's' : '' }}
        @endcomponent
        @component('components.molecules._m-link-list')
            @slot('variation', 'm-link-list--download')
            @slot('links', $article->otherResources);
        @endcomponent
    @endif

    @if ($article->speakers)
        @component('components.blocks._text')
            @slot('font', 'f-module-title-2')
            @slot('tag', 'h4')
            Speaker{{ sizeof($article->speakers) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($article->speakers as $speaker)
            @component('components.molecules._m-row-block')
                @slot('variation', 'm-row-block--inline-title m-row-block--keyline-top')
                @slot('title', $speaker['title'] ?? null)
                @slot('img', $speaker['img'] ?? null)
                @slot('text', $speaker['text'] ?? null)
                @slot('titleFont', 'f-subheading-1')
                @slot('textFont', ($article->articleType === 'editorial') ? 'f-body-editorial' : 'f-body')
            @endcomponent
        @endforeach
    @endif

    @if ($article->sponsors)
        @component('components.blocks._text')
            @slot('font', 'f-module-title-2')
            @slot('tag', 'h4')
            Sponsors
        @endcomponent
        @component('components.blocks._blocks')
            @slot('editorial', ($article->articleType === 'editorial'))
            @slot('blocks', $article->sponsors ?? null)
        @endcomponent
    @endif

    @if ($article->futherSupport)
        @component('components.molecules._m-row-block')
            @slot('variation', 'm-row-block--keyline-top')
            @slot('title', $article->futherSupport['title'] ?? null)
            @slot('img', $article->futherSupport['logo'] ?? null)
            @slot('text', $article->futherSupport['text'] ?? null)
        @endcomponent
    @endif

    @if ($article->citation)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Citation
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-secondary')
            {{ $article->citation }}
        @endcomponent
    @endif

    @if ($article->references)
        @component('components.organisms._o-accordion')
            @slot('variation', 'o-accordion--section')
            @slot('items', array(
                array(
                    'title' => "References",
                    'active' => true,
                    'blocks' => array(
                        array(
                            "type" => 'references',
                            "items" => $article->references
                        ),
                    ),
                ),
            ))
            @slot('loopIndex', 'references')
        @endcomponent
    @endif

    @if ($article->topics)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Topics
        @endcomponent
        <ul class="m-inline-list">
        @foreach ($article->topics as $topic)
            <li class="m-inline-list__item"><a class="tag f-tag" href="{{ $topic['href'] }}">{{ $topic['label'] }}</a></li>
        @endforeach
        </ul>
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $article->articleType)
    @endcomponent
  </div>

  <a class="o-article__top-link" href="#a17">
    <svg class="icon--arrow" aria-label="top of page">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow">
    </svg>
  </a>

</article>

@if ($article->comments)
    @component('components.organisms._o-accordion')
        @slot('variation', 'o-accordion--section')
        @slot('items', array(
            array(
                'title' => "Comments",
                'blocks' => array(
                    array(
                        "type" => 'embed',
                        "content" => $article->comments
                    ),
                ),
            ),
        ))
        @slot('loopIndex', 'references')
    @endcomponent
@endif

@if ($article->relatedEventsByDay)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => '#')))
        @slot('id', 'related_events')
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
        @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary')))
    @endcomponent
@endif

@if ($article->relatedExhibitions)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all exhibitions', 'href' => '#')))
        {{ $article->relatedExhibitionsTitle ? $article->relatedExhibitionsTitle : "Related Exhibitions" }}
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedExhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($article->relatedEvents)
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
        @foreach ($article->relatedEvents as $event)
            @component('components.molecules._m-listing----event')
                @slot('event', $event)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($article->relatedArticles)
    @component('components.molecules._m-title-bar')
        Further Reading
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedArticles as $editorial)
            @component('components.molecules._m-listing----article')
                @slot('article', $editorial)
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
    @component('components.atoms._hr')
        @slot('variation','hr--flush-top')
    @endcomponent
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('maintainOrder','false')
        @foreach ($article->exploreFuther['items'] as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot($item->type, $item)
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
        @foreach ($article->recentlyViewedArtworks as $artwork)
            @component('components.molecules._m-listing----artwork-minimal')
                @slot('artwork', $artwork)
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
