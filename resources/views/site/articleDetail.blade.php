@extends('layouts.app')

@section('content')

<article class="o-article{{ ($item->articleType === 'editorial') ? ' o-article--editorial' : '' }}">

  @component('components.molecules._m-article-header')
    @slot('editorial', ($item->articleType === 'editorial'))
    @slot('headerType', ($item->headerType ?? null))
    @slot('variation', ($item->headerVariation ?? null))
    @slot('title', $item->title)
    @slot('date', $item->date)
    @slot('type', $item->type)
    @slot('intro', $item->intro)
    @slot('img', $item->headerImage)
    @slot('galleryImages', $item->galleryImages)
    @slot('nextArticle', $item->nextArticle)
    @slot('prevArticle', $item->prevArticle)
  @endcomponent

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@large+' : '' }}">
    @if ($item->articleType !== 'artwork')
        @component('components.molecules._m-article-actions')
            @slot('articleType', $item->articleType)
        @endcomponent
    @endif

    @if ($item->author)
        @component('components.molecules._m-author')
            @slot('variation', 'm-author---keyline-top')
            @slot('editorial', ($item->articleType === 'editorial'))
            @slot('img', $item->author['img'] ?? null);
            @slot('name', $item->author['name'] ?? null);
            @slot('link', $item->author['link'] ?? null);
            @slot('date', $item->date ?? null);
        @endcomponent
    @endif

    @if ($item->nav)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $item->nav);
        @endcomponent
    @endif

    @if ($item->onView)
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
            <a href="{{ $item->onView['href'] }}">{{ $item->onView['label'] }}</a>
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

  <div class="o-article__secondary-actions{{ ($item->headerType === 'gallery') ? ' o-article__secondary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@medium+' : '' }}">
    @if ($item->articleType === 'exhibition')
        @component('components.molecules._m-ticket-actions----exhibition')
        @endcomponent
    @endif

    @if ($item->articleType === 'event')
        @component('components.molecules._m-ticket-actions----event')
            @slot('ticketPrices', $item->ticketPrices);
            @slot('ticketLink', $item->ticketLink);
        @endcomponent
    @endif

    @if ($item->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $item->featuredRelated['type'])
          @slot('items', $item->featuredRelated['items'])
          @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
          @slot('imageSettings', array(
              'fit' => 'crop',
              'ratio' => '16:9',
              'srcset' => array(200,400,600),
              'sizes' => aic_imageSizes(array(
                    'xsmall' => '0',
                    'small' => '23',
                    'medium' => '18',
                    'large' => '13',
                    'xlarge' => '13',
              )),
          ))
      @endcomponent
    @endif
  </div>

  @if ($item->headerType === 'gallery')
  <div class="o-article__inline-header">
    @if ($item->title)
      @component('components.atoms._title')
          @slot('tag','h1')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          {{ $item->title }}
      @endcomponent
    @endif
    @if ($item->subtitle)
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-subtitle')
          {{ $item->subtitle }}
      @endcomponent
    @endif
  </div>
  @endif

  @if ($item->heading and $item->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $item->heading }}
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
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '16:9',
            'srcset' => array(200,400,600),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '23',
                  'medium' => '18',
                  'large' => '0',
                  'xlarge' => '0',
            )),
        ))
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks" data-behavior="articleBodyInViewport">

    @if ($item->articleType === 'artwork')
        @component('components.blocks._blocks')
            @slot('blocks', $item->blocks ?? null)
        @endcomponent
    @else
        {!! $item->renderBlocks() !!}
    @endif

    @if ($item->catalogues)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Catalogue{{ sizeof($item->catalogues) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($item->catalogues as $catalogue)
            @component('components.molecules._m-download-file')
                @slot('file', $catalogue)
                @slot('imageSettings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                ))
            @endcomponent
        @endforeach
    @endif

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
                @slot('imageSettings', array(
                    'srcset' => array(300,600,800,1200,1600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '58',
                          'medium' => '38',
                          'large' => '28',
                          'xlarge' => '28',
                    ))
                ))
            @endcomponent
        @endforeach
    @endif

    @if ($item->otherResources)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Other Resource{{ sizeof($item->otherResources) > 1 ? 's' : '' }}
        @endcomponent
        @component('components.molecules._m-link-list')
            @slot('variation', 'm-link-list--download')
            @slot('links', $item->otherResources);
        @endcomponent
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
                @slot('imageSettings', array(
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '13',
                          'small' => '13',
                          'medium' => '8',
                          'large' => '8',
                          'xlarge' => '8',
                    )),
                ))
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
            @slot('variation', 'm-row-block--keyline-top')
            @slot('title', $item->futherSupport['title'] ?? null)
            @slot('img', $item->futherSupport['logo'] ?? null)
            @slot('text', $item->futherSupport['text'] ?? null)
            @slot('imageSettings', array(
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '13',
                      'small' => '13',
                      'medium' => '8',
                      'large' => '8',
                      'xlarge' => '8',
                )),
            ))
        @endcomponent
    @endif

    @if ($item->citation)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Citation
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-secondary')
            {{ $item->citation }}
        @endcomponent
    @endif

    @if ($item->references)
        @component('components.organisms._o-accordion')
            @slot('variation', 'o-accordion--section')
            @slot('items', array(
                array(
                    'title' => "References",
                    'active' => true,
                    'blocks' => array(
                        array(
                            "type" => 'references',
                            "items" => $item->references
                        ),
                    ),
                ),
            ))
            @slot('loopIndex', 'references')
        @endcomponent
    @endif

    @if ($item->topics)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Topics
        @endcomponent
        <ul class="m-inline-list">
        @foreach ($item->topics as $topic)
            <li class="m-inline-list__item"><a class="tag f-tag" href="{{ $topic['href'] }}">{{ $topic['label'] }}</a></li>
        @endforeach
        </ul>
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $item->articleType)
    @endcomponent
  </div>

  <a class="o-article__top-link" href="#a17">
    <svg class="icon--arrow" aria-label="top of page">
      <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow">
    </svg>
  </a>

</article>

@if ($item->comments)
    @component('components.organisms._o-accordion')
        @slot('variation', 'o-accordion--section')
        @slot('items', array(
            array(
                'title' => "Comments",
                'blocks' => array(
                    array(
                        "type" => 'embed',
                        "content" => $item->comments
                    ),
                ),
            ),
        ))
        @slot('loopIndex', 'references')
    @endcomponent
@endif

@if ($item->relatedEventsByDay)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => '#')))
        @slot('id', 'related_events')
        Related Events
    @endcomponent
    @component('components.organisms._o-row-listing')
        @foreach ($item->relatedEventsByDay as $date)
            @component('components.molecules._m-date-listing')
                @slot('date', $date)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '13',
                          'medium' => '13',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
                @slot('imageSettingsOnGoing', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '7',
                          'medium' => '7',
                          'large' => '7',
                          'xlarge' => '7',
                    )),
                ))
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
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
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
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
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
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($item->exploreFuther)
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', '')
        @slot('linksPrimary', $item->exploreFuther['nav'])
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
        @foreach ($item->exploreFuther['items'] as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' || $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' || $item->type !== 'artwork') ? '16:9' : null,
                    'srcset' => array(200,400,600),
                    'sizes' => aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '3',
                          'large' => '3',
                          'xlarge' => '3',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif

@component('components.organisms._o-recently-viewed')
    @slot('artworks',$item->recentlyViewedArtworks)
@endcomponent

@component('components.organisms._o-interested-themes')
    @slot('themes',$item->interestedThemes)
@endcomponent

@endsection
