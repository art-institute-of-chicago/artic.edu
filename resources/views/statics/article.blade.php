@extends('layouts.app')

@section('content')

<article class="o-article{{ ($article->articleType === 'editorial') ? ' o-article--editorial' : '' }}">

  @component('components.molecules._m-article-header')
    @slot('editorial', ($article->articleType === 'editorial'))
    @slot('headerType', ($article->headerType ?? null))
    @slot('variation', ($article->headerVariation ?? null))
    @slot('title', $article->title)
    @slot('date', $article->date)
    @slot('dateStart', $article->dateStart)
    @slot('dateEnd', $article->dateEnd)
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
            @slot('icsLink', $article->icsLink ?? null)
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
            @slot('ticketLink', $article->ticketLink);
            @slot('buttonCaption', $article->ticketPrices);
        @endcomponent
    @endif

    @if ($article->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $article->featuredRelated['type'])
          @slot('items', $article->featuredRelated['items'])
          @slot('titleFont', "f-list-1")
          @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
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

  @if ($article->intro and $article->headerType !== 'super-hero')
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
        @slot('titleFont', "f-list-1")
        @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
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

  <div class="o-article__body o-blocks">
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
                @slot('imageSettings', array(
                    'srcset' => array(120,240),
                    'sizes' => '120px',
                ))
            @endcomponent
        @endforeach
    @endif

    @if ($article->pictures)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Picture{{ sizeof($article->pictures) > 1 ? 's' : '' }}
        @endcomponent
        @foreach ($article->pictures as $picture)
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
            @slot('variation', 'm-row-block--keyline-top o-blocks__block')
            @slot('title', $article->futherSupport['title'] ?? null)
        @endcomponent
        @component('components.molecules._m-row-block')
            @slot('img', $article->futherSupport['logo'] ?? null)
            @slot('text', $article->futherSupport['text'] ?? null)
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
            @slot('variation', 'o-accordion--section o-blocks__block')
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
        @slot('icsLink', $article->icsLink ?? null)
    @endcomponent
  </div>

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

@if (isset($relatedEventsByDay))
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => '#')))
        @slot('id', 'related_events')
        Related Events
    @endcomponent
    @component('components.organisms._o-row-listing')
        @slot('id', 'eventsList')

        @foreach ($relatedEventsByDay as $date => $events)
            @component('components.molecules._m-date-listing')
                @slot('date', $date)
                @slot('events', $events)
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
        @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary', 'loadMoreUrl' => '/exhibitions_load_more', 'loadMoreTarget' => '#eventsList')))
    @endcomponent
@endif

@if ($article->relatedExhibitions)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all exhibitions', 'href' => '#')))
        {{ $article->relatedExhibitionsTitle ? $article->relatedExhibitionsTitle : "Related Exhibitions" }}
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedExhibitions as $item)
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

@if ($article->relatedEvents)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => '#')))
        Related Events
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedEvents as $item)
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

@if ($article->relatedArticles)
    @component('components.molecules._m-title-bar')
        Further Reading
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedArticles as $item)
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

@if ($article->relatedOffers)
    @component('components.molecules._m-title-bar')
        Releated Offers
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedOffers as $item)
            @component('components.molecules._m-listing----offer')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '18',
                          'xlarge' => '18',
                    )),
                ))
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
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','false')
        @foreach ($article->exploreFuther['items'] as $item)
            @component('components.molecules._m-listing----'.$item->type)
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                    'srcset' => array(200,400,600),
                    'sizes' => aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '3',
                          'large' => '4',
                          'xlarge' => '4',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif

@component('components.organisms._o-recently-viewed')
    @slot('artworks',$article->recentlyViewedArtworks ?? null)
@endcomponent

@component('components.organisms._o-interested-themes')
    @slot('themes',$article->interestedThemes ?? null)
@endcomponent

@endsection
