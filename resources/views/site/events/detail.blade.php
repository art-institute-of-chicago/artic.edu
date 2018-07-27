@extends('layouts.app')

@section('content')

<article class="o-article" itemscope itemtype="http://schema.org/VisualArtsEvent">
  @component('site.shared._schemaItemProps')
    @slot('itemprops',$item->present()->itemprops ?? null)
  @endcomponent

  @component('components.molecules._m-article-header')
    @slot('editorial', false)
    @slot('headerType', $item->present()->headerType)
    @slot('title', $item->title)
    @slot('formattedDate', $item->present()->formattedNextOcurrence)
    @slot('type', $item->is_member_exclusive ? 'Member Exclusive' : $item->present()->type)
    @slot('img', $item->imageAsArray('hero'))
    @slot('credit', $item->hero_caption)
  @endcomponent

  <div class="o-article__primary-actions{{ ($item->headerType === 'gallery') ? ' o-article__primary-actions--inline-header' : '' }}">

    @component('components.molecules._m-article-actions')
        @slot('articleType', 'event')
        @slot('icsLink', route('events.ics', $item) ?? null)
    @endcomponent

    @if ($item->present()->navigation)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@large+')
            @slot('links', $item->present()->navigation);
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

  <div class="o-article__secondary-actions{{ ($item->present()->ticketStatus == '') ? ' o-article__secondary-actions--empty@small-' : '' }}">

    @switch ($item->present()->ticketStatus)
        @case('buy-ticket')
            @component('components.molecules._m-ticket-actions----event')
                @slot('ticketLink', $item->buy_tickets_link);
                @slot('buttonText', $item->buy_button_text);
                @slot('buttonCaption', $item->buy_button_caption);
            @endcomponent
            @break
        @case('free')
            @component('components.molecules._m-ticket-actions----event')
                @slot('buttonText', 'FREE');
            @endcomponent
            @break
        @case('register')
            @component('components.molecules._m-ticket-actions----event')
                @slot('buttonText', 'Registration Required');
            @endcomponent
            @break
        @case('member-exclusive')
            @component('components.molecules._m-ticket-actions----event')
                @slot('buttonText', 'Members Exclusive');
            @endcomponent
            @break
        @case('rsvp')
            @component('components.molecules._m-ticket-actions----event')
                @slot('buttonText', 'RSVP');
                @slot('ticketLink', $item->rsvp_link);
            @endcomponent
            @break
        @case('sold-out')
            @component('components.molecules._m-ticket-actions----event')
                @slot('buttonText', 'Sold out');
            @endcomponent
            @break
    @endswitch

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

  @if ($item->description and $item->headerType !== 'super-hero')
  <div class="o-article__intro" itemprop="description">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $item->description }}
    @endcomponent
  </div>
  @endif

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
    <div class='o-blocks' itemprop="description">
      {!! $item->renderBlocks(false) !!}
    </div>

      {{--  @component('components.blocks._blocks')
        @slot('editorial', false)
        @slot('blocks', $item->blocks ?? null)
        @slot('dropCapFirstPara', false)
        @endcomponent  --}}

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
                {{-- @slot('title', $sponsor->title ?? null) --}}
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

@endsection
