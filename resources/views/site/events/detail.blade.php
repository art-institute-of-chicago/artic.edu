@extends('layouts.app')

@section('content')

<article class="o-article" itemscope itemtype="http://schema.org/VisualArtsEvent">
  @component('site.shared._schemaItemProps')
    @slot('itemprops',$item->present()->itemprops ?? null)
  @endcomponent

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->present()->headerType)
    @slot('title', $item->present()->title)
    @slot('title_display', $item->present()->title_display)
    @slot('formattedDate', $item->present()->formattedNextOccurrence)
    @slot('type', $item->is_member_exclusive ? 'Member Exclusive' : ($item->audience === \App\Models\Event::LUMINARY ? 'Luminary' : $item->present()->type))
    @slot('img', $item->imageAsArray('hero'))
    @slot('imgMobile', $item->imageAsArray('mobile_hero'))
    @slot('credit', $item->present()->hero_caption)
  @endcomponent

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}">

    @component('components.molecules._m-article-actions')
        @slot('articleType', 'event')
        @slot('icsLink', route('events.ics', $item->id) ?? null)
    @endcomponent

    @if ($item->present()->navigation())
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $item->present()->navigation());
        @endcomponent
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  @if ($item->present()->navigation())
    <div class="o-article__meta">
        @component('components.molecules._m-link-list')
            @slot('links', $item->present()->navigation());
        @endcomponent
    </div>
  @endif

  <div class="o-article__secondary-actions{{ ($item->present()->ticketStatus == '') ? ' o-article__secondary-actions--empty@small-' : '' }}">

    @component('components.molecules._m-ticket-actions----event')
        @slot('ticketLink', $item->buy_tickets_link);
        @slot('buttonText', $item->present()->buyButtonText);
        @slot('buttonCaption', $item->buy_button_caption);
        @slot('isTicketed', $item->present()->isTicketed);
        @if ($item->present()->isSoldOut)
            @slot('disabled',true)
        @endif
        @slot('eventName',$item->present()->title)
    @endcomponent

    @dump($item->hasFeaturedRelated())
    @component('site.shared._featuredRelated')
        @slot('item', $item)
        @slot('variation', 'u-show@medium+')
        @slot('autoRelated', $autoRelated)
        @slot('featuredRelated', $featuredRelated)
    @endcomponent
  </div>

  @if ($item->description and $item->headerType !== 'super-hero')
  <div class="o-article__intro" itemprop="description">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        @slot('tag', 'div')
        {!! $item->present()->description !!}
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks">
    <div class='o-blocks' itemprop="description">
      {!! $item->renderBlocks(false) !!}
    </div>

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

    @component('site.shared._sponsors')
        @slot('sponsors', $item->sponsors)
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', 'event')
        @slot('icsLink', $item->icsLink ?? null)
    @endcomponent
  </div>

</article>

@if ($item->events()->count() > 0)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('label' => 'See all events', 'href' => route('events'))))
        Related Events
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($item->events as $item)
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

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/videojs.js')}}"></script>
@endsection
