@extends('layouts.app')

@section('content')

<article class="o-article" itemscope itemtype="http://schema.org/ExhibitionEvent">
  @component('site.shared._schemaItemProps')
    @slot('itemprops',$item->present()->itemprops ?? null)
  @endcomponent

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->present()->headerType)
    {{-- @slot('variation', ($item->headerVariation ?? null)) --}}
    @slot('title', $item->title)
    @slot('date', $item->present()->date)
    @slot('dateStart', $item->present()->startAt)
    @slot('dateEnd', $item->present()->endAt)
    @slot('type', $item->present()->exhibitionType)
    @slot('intro', $item->header_copy)
    @slot('img', $item->imageAsArray('hero'))
    @slot('credit', $item->hero_caption)
  @endcomponent

  <div class="o-article__primary-actions">
    @component('components.molecules._m-article-actions')
        @slot('articleType', 'exhibition')
    @endcomponent

    @if ($item->present()->navigation)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $item->present()->navigation)
        @endcomponent
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  @if ($item->present()->navigation)
      <div class="o-article__meta">
            @component('components.molecules._m-link-list')
                @slot('links', $item->present()->navigation);
            @endcomponent
      </div>
  @endif

  <div class="o-article__secondary-actions">

    @unless ($item->isClosed)
        @component('components.molecules._m-ticket-actions----exhibition')
            @slot('pricingAttendanceMessage', $item->exhibition_message)
        @endcomponent
    @endunless

    {{-- This is the featured element at the side --}}
    @if ($item->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $item->featuredRelated['type'])
          @slot('items', $item->featuredRelated['items'])
          @slot('titleFont', "f-list-1")
          @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
      @endcomponent
    @endif
  </div>

  @if ($item->header_copy and $item->present()->headerType !== 'super-hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $item->header_copy }}
    @endcomponent
  </div>
  @endif

  {{-- This is the featured element at the side --}}
  @if ($item->featuredRelated)
  {{-- dupe 😢 - hidden medium+ --}}
  <div class="o-article__related">
    @component('components.blocks._inline-aside')
        @slot('type', $item->featuredRelated['type'])
        @slot('items', $item->featuredRelated['items'])
        @slot('titleFont', "f-list-1")
        @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks">
    {!! $item->renderBlocks(false) !!}

    @if ($item->isClosed)
        {{-- History Detail - Exhibition PDF's --}}
        @if ($item->historyDocuments)
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-subheading-1')
                @slot('tag', 'h4')
                {{ str_plural('Catalogue', $item->historyDocuments->count()) }}
            @endcomponent
            @foreach ($item->historyDocuments->toArray() as $catalogue)
                @component('components.molecules._m-download-file')
                    @slot('file', $catalogue)
                @endcomponent
            @endforeach
        @endif

        {{-- History Detail - Exhibition Photos --}}
        @if ($item->historyImages)
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-subheading-1')
                @slot('tag', 'h4')
                {{ str_plural('Picture', $item->historyImages->count()) }}
            @endcomponent
            @foreach ($item->historyImages->toArray() as $picture)
                    @component('components.molecules._m-media')
                    @slot('variation', 'o-blocks__block')
                    @slot('item', $picture)
                @endcomponent
            @endforeach
        @endif
    @endif

    {{-- History Detail - Other exhibition resources --}}
    {{--     @if ($item->otherResources)
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
    @endif --}}

    @if (strlen($item->sponsors_description) > 0)
        @component('components.blocks._text')
            @slot('font', 'f-module-title-2')
            @slot('tag', 'h4')
            Sponsors
        @endcomponent

        @component('components.blocks._text')
            {!! $item->sponsors_description !!}
        @endcomponent
    @endif

    @if ($item->sponsors() && $item->sponsors()->count() > 0)
        @component('components.molecules._m-row-block')
            @slot('variation', 'm-row-block--keyline-top o-blocks__block')
            @slot('title', ($item->sponsors_sub_copy != null && $item->sponsors_sub_copy != '') ? preg_replace('/<p>|<\/p>/i', '', $item->sponsors_sub_copy) : "Further support has been provided by:")
        @endcomponent

        @foreach ($item->sponsors as $sponsor)
            @component('components.molecules._m-row-block')
                @slot('title', $sponsor->title ?? null)
                @slot('img', $sponsor->imageFront('profile', 'default') ?? null)
                @slot('text', $sponsor->copy ?? null)
                @slot('variation', 'm-row-block--squared')
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '1:1',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '13',
                          'small' => '10',
                          'medium' => '5',
                          'large' => '5',
                          'xlarge' => '5',
                    )),
                ))
            @endcomponent
        @endforeach
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

@if ($item->offers() && $item->offers()->count() > 0)
    @component('components.molecules._m-title-bar')
        Related Offers
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('behavior','dragScroll')
        @foreach ($item->offers as $offer)
            @component('components.molecules._m-listing----offer')
                @slot('item', $offer)
                @slot('img', $offer->imageFront('hero') ?? null)
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

@if ($relatedEventsByDay)
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
                @slot('gtmAttributes', 'data-gtm-event="exhibition-events" data-gtm-event-category="nav-link"')
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
                    'sizes' => aic_imageSizes(array(
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

@if ($item->shopItems() && $item->shopItems()->count() > 0)
    @component('components.molecules._m-title-bar')
        Related Offers
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('behavior','dragScroll')
        @foreach ($item->apiModels('shopItems', 'ShopItem') as $item)
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

@endsection
