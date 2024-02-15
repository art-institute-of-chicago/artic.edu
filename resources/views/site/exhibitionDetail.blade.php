@extends('layouts.app')

@section('content')

<article class="o-article" itemscope itemtype="http://schema.org/ExhibitionEvent">
  @component('site.shared._schemaItemProps')
    @slot('itemprops',$item->present()->itemprops ?? null)
  @endcomponent

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->present()->headerType)
    @slot('title', $item->present()->title)
    @slot('title_display', $item->present()->title_display)
    @slot('type', $item->present()->exhibitionType)
    @slot('intro', $item->present()->header_copy)
    @slot('img', $item->imageAsArray('hero', $item->cms_exhibition_type == \App\Models\Exhibition::SPECIAL ? 'special' : 'default'))
    @slot('imgMobile', $item->imageAsArray('mobile_hero'))
    @slot('credit', $item->present()->hero_caption)
    @slot('previewDateStart', $item->member_preview_start_date)
    @slot('previewDateEnd', $item->member_preview_end_date)
    @slot('formattedDate', $item->present()->date_display_override)
    @slot('dateStart', $item->present()->startAt)
    @slot('dateEnd', $item->present()->endAt)
    @slot('date', $item->present()->date)
  @endcomponent

  <div class="o-article__primary-actions">
    @component('components.molecules._m-article-actions')
        @slot('articleType', 'exhibition')
    @endcomponent

    {{-- dupe 😢 - shows xlarge+ --}}
    @if ($item->present()->navigation())
        <div>
            @component('components.molecules._m-link-list')
                @slot('variation', 'u-show@large+')
                @slot('links', $item->present()->navigation())
            @endcomponent
        </div>
        <div {!! $item->present()->addInjectAttributes('u-show@large+') !!}>
            @component('components.molecules._m-link-list')
                @slot('variation', 'u-show@large+')
                @slot('links', []) {{-- Leave an empty space where injected content will be displayed --}}
            @endcomponent
        </div>
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  @if ($item->present()->navigation())
        <div class="o-article__meta">
            @component('components.molecules._m-link-list')
                @slot('links', $item->present()->navigation());
            @endcomponent
        </div>
        <div class="o-article__meta" {!! $item->present()->addInjectAttributes() !!}>
            @component('components.molecules._m-link-list')
                @slot('links', []); {{-- Leave an empty space where injected content will be displayed --}}
            @endcomponent
        </div>
  @endif

  <div class="o-article__secondary-actions">

    @unless ($item->isClosed)
        @component('components.molecules._m-ticket-actions----exhibition')
            @slot('pricingAttendanceMessage', $item->exhibition_message)
            @slot('exhibitionName', $item->present()->title)
        @endcomponent
    @endunless

    @component('site.shared._featuredRelated')
        @slot('item', $item)
        @slot('autoRelated', $autoRelated)
        @slot('featuredRelated', $featuredRelated)
        @slot('variation', 'u-show@medium+')
    @endcomponent
  </div>

  @if ($item->header_copy and $item->present()->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        @slot('tag', 'div')
        {!! $item->present()->header_copy !!}
    @endcomponent
  </div>
  @endif

  @if ($item->hasFeaturedRelated())
      <div class="o-article__related">
          @component('site.shared._featuredRelated')
              @slot('item', $item)
              @slot('autoRelated', $autoRelated)
              @slot('featuredRelated', $featuredRelated)
          @endcomponent
      </div>
  @endif

  <div class="o-article__body o-blocks">
    {!! $item->renderBlocks(false) ?: $item->description !!}

    @if ($item->isClosed)
        {{-- History Detail - Exhibition PDF's --}}
        @if ($item->historyDocuments)
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-subheading-1')
                @slot('tag', 'h4')
                {{ Str::plural('Catalogue', $item->historyDocuments->count()) }}
            @endcomponent
            @foreach ($item->historyDocuments->toArray() as $catalogue)
                @component('components.molecules._m-download-file')
                    @slot('file', $catalogue)
                @endcomponent
            @endforeach
        @endif

        {{-- History Detail - Microsites --}}
        @if ($item->sites)
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-subheading-1')
                @slot('tag', 'h4')
                {{ Str::plural('Archived Microsite', count($item->sites)) }}
            @endcomponent
            @component('components.molecules._m-link-list')
                @slot('variation', 'm-link-list--exhibition-microsite')
                @slot('links', array_map(function ($site) {
                    return [
                        'href' => $site->web_url,
                        'label' => $site->title,
                        'iconAfter' => 'new-window',
                    ];
                }, $item->sites))
            @endcomponent
        @endif

        {{-- History Detail - Exhibition Photos --}}
        @if ($item->present()->getHistoryImages()->count() > 0)
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-subheading-1')
                @slot('tag', 'h4')
                Installation {{ Str::plural('Photo', $item->present()->getHistoryImages()->count()) }}
            @endcomponent
            @foreach ($item->present()->getHistoryImagesForMediaComponent() as $picture)
                @component('components.molecules._m-media')
                    @slot('variation', 'o-blocks__block')
                    @slot('item', $picture)
                @endcomponent
            @endforeach
        @endif
    @endif

    @component('site.shared._sponsors')
        @slot('sponsors', $item->sponsors)
    @endcomponent

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
            @slot('variation', 'o-accordion--section o-blocks__block')
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
            <li class="m-inline-list__item">
                @if (!empty($topic['href']))
                    <a class="tag f-tag" href="{{ $topic['href'] }}">{{ $topic['label'] }}</a>
                @else
                    <span class="tag f-tag">{{ $topic['label'] }}</span>
                @endif
            </li>
        @endforeach
        </ul>
    @endif

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', 'exhibition')
    @endcomponent
  </div>

</article>

@if ($item->offers() && $item->offers()->count() > 0)
    @component('components.molecules._m-title-bar')
        Related Offers
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @foreach ($item->offers as $offer)
            @component('components.molecules._m-listing----offer')
                @slot('item', $offer)
                @slot('img', $offer->imageFront('hero') ?? null)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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

@if ($item->shopItems() && $item->shopItems()->count() > 0)
    @component('site.shared._featuredProducts')
        @slot('title', $item->product_section_title ?: 'Related Products')
        @slot('titleLinks', [
            [
                'label' => $item->product_section_title_link_label ?: 'Explore the shop',
                'href' => $item->product_section_title_link_href ?: 'https://shop.artic.edu',
            ]
        ])
        @slot('products', $item->apiModels('shopItems', 'ShopItem'))
    @endcomponent
@endif

@if ($relatedEventsByDay && $relatedEventsByDay->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => route('events'))))
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
                @slot('exhibitionTitle', $item->present()->title)
            @endcomponent
        @endforeach
    @endcomponent
    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('label' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary', 'loadMoreUrl' => route('exhibitions.loadMoreRelatedEvents', $item), 'loadMoreTarget' => '#eventsList')))
    @endcomponent
@endif

@if ($item->exhibitions() && $item->exhibitions()->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all exhibitions', 'href' => route('exhibitions'))))
        {{-- Title can be Related Exhibitions or On View for Exhibition History --}}
        Related Exhibitions
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($item->apiModels('exhibitions', 'Exhibition') as $exhibition)
            @component('components.molecules._m-listing----exhibition')
                @slot('item', $exhibition)
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
                @slot('gtmAttributes', 'data-gtm-event="exhibition-recirculation" data-gtm-event-category="nav-link"')
            @endcomponent
        @endforeach
    @endcomponent
@endif

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
