@extends('layouts.app')

@section('content')

<article class="o-article{{ ($item->articleType === 'editorial') ? ' o-article--editorial' : '' }}" itemscope itemtype="http://schema.org/BlogPosting">
  @component('site.shared._schemaItemProps')
    @slot('itemprops',$item->present()->itemprops ?? null)
  @endcomponent

  @component('components.molecules._m-article-header')
    @slot('editorial', ($item->articleType === 'editorial'))
    @slot('headerType', $item->present()->headerType)
    @slot('variation', ($item->headerVariation ?? null))
    @slot('title', $item->present()->title)
    @slot('title_display', $item->present()->title_display)
    @slot('date', $item->date)
    @slot('type', $item->present()->subtype)
    @slot('intro', $item->present()->heading)
    @slot('img', $item->imageFront('hero'))
    @slot('imgMobile', $item->imageFront('mobile_hero'))
    @slot('galleryImages', $item->galleryImages)
    @slot('nextArticle', $item->nextArticle)
    @slot('prevArticle', $item->prevArticle)
    @slot('credit', $item->hero_caption ?? null)
  @endcomponent

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}{{ ($item->articleType === 'artwork') ? ' u-show@large+' : '' }}">
    @if ($item->articleType !== 'artwork')
        @component('components.molecules._m-article-actions')
            @slot('articleType', $item->articleType)
        @endcomponent
    @endif

    @if ($item->showAuthorsWithLinks())
        @component('components.molecules._m-author')
            @slot('variation', 'm-author---keyline-top')
            @slot('editorial', ($item->articleType === 'editorial'))
            @slot('img', $item->imageFront('author', 'square'));
            @slot('name', $item->showAuthorsWithLinks() ?? null);
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

    @component('site.shared._featuredRelated')
        @slot('item', $item)
        @slot('variation', 'u-show@medium+')
        @slot('autoRelated', $autoRelated)
        @slot('featuredRelated', $featuredRelated)
    @endcomponent
  </div>

  @if ($item->headerType === 'gallery')
  <div class="o-article__inline-header">
    @if ($item->title)
      @component('components.atoms._title')
          @slot('tag','h1')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          @slot('title', $item->present()->title)
          @slot('title_display', $item->present()->title_display)
      @endcomponent
    @endif

    @if ($item->subtitle)
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-subtitle')
          {!! $item->present()->subtitle !!}
      @endcomponent
    @endif
  </div>
  @endif

  @if ($item->heading and $item->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        @slot('tag', 'div')
        {!! $item->present()->heading !!}
    @endcomponent
  </div>
  @endif

  @if ($item->showAuthorsWithLinks())
      <p class="print-authors type f-tag">By {{ $item->showAuthorsWithLinks() ?? null }}</p>
  @endif

  {{-- For articles, this shows below body, not float-right --}}
  @if ($item->hasFeaturedRelated())
      <div class="o-article__related">
        @component('site.shared._featuredRelated')
            @slot('item', $item)
            @slot('autoRelated', $autoRelated)
            @slot('featuredRelated', $featuredRelated)
        @endcomponent
      </div>
  @endif

  <div class="o-article__body o-blocks" itemprop="articleBody">

    @php
        global $_collectedReferences;
        $_collectedReferences = [];
    @endphp

    {!! $item->renderBlocks(false, [], [
      'pageTitle' => $item->meta_title ?: $item->title
    ]) !!}

    @if (isset($item->sponsors) && $item->sponsors->count() > 0)
        <hr>

        @component('site.shared._sponsors')
            @slot('sponsors', $item->sponsors)
        @endcomponent
    @endif

    @if (sizeof($_collectedReferences))
        @component('components.organisms._o-accordion')
            @slot('variation', 'o-accordion--section o-blocks__block')
            @slot('items', array(
                array(
                    'title' => "References",
                    'active' => true,
                    'blocks' => array(
                        array(
                            "type" => 'references',
                            "items" => $_collectedReferences
                        ),
                    ),
                ),
            ))
            @slot('loopIndex', 'references')
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

    @if ($item->citations)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            Citation
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-secondary')
            {!! $item->present()->citations !!}
        @endcomponent
    @endif

    @if ($item->topics)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-subheading-1')
            @slot('tag', 'h4')
            @slot('id', 'h-topics')
            Topics
        @endcomponent
        <ul class="m-inline-list" aria-labelledby="h-topics">
        @foreach ($item->topics as $topic)
            <li class="m-inline-list__item">
                @if (!empty($topic['id']))
                    <a class="tag f-tag" href="{{ route('articles', ['category' => $topic['id']]) }}">{{ $topic['name'] }}</a>
                @else
                    <span class="tag f-tag">{{ $topic['name'] }}</span>
                @endif
            </li>
        @endforeach
        </ul>
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $item->articleType)
    @endcomponent
  </div>

</article>

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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
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
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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

<section>
    @component('site.shared._relatedItems')
        @slot('title', $furtherReadingTitle ?? null)
        @slot('relatedItems', $furtherReadingItems ?? null)
    @endcomponent
</section>

@if ($item->exploreFurther)
<div id="exploreFurther">
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', '')
        @slot('linksPrimary', $item->exploreFurther['nav'])
    @endcomponent
    @if (!empty($article->exploreFurther['items']))
        @component('components.organisms._o-pinboard')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('maintainOrder','false')
            @foreach ($article->exploreFurther['items'] as $item)
                @component('components.molecules._m-listing----' . strtolower($item->type))
                    @slot('variation', 'o-pinboard__item')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => ($item->type !== 'highlight' and $item->type !== 'artwork') ? 'crop' : null,
                        'ratio' => ($item->type !== 'highlight' and $item->type !== 'artwork') ? '16:9' : null,
                        'srcset' => array(200,400,600),
                        'sizes' => ImageHelpers::aic_gridListingImageSizes(array(
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
    @if (!empty($article->exploreFurther['tags']))
        @component('components.molecules._m-multi-col-list')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('items',$article->exploreFurther['tags'])
        @endcomponent
    @endif
</div>
@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/layeredImageViewer.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/mirador.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/virtualTour.js')}}"></script>
    <script src="/virtual-tours/tour.js"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
