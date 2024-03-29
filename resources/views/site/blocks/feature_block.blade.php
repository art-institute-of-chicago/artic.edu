@php

    // Persistent fields from CMS
    $heading = $block->input('feature_heading');
    $browseLabel = $block->input('browse_label');
    $browseLink = $block->input('browse_link');
    $ratio = $block->input('image_ratio');

    $feature_type = $block->input('feature_type');
    $columns = $block->input('columns');

    switch ($feature_type) {

        case 'articles':
            $items = $block->getRelated('articles');
            break;

        case 'digital_publications':
            $items = $block->getRelated('digitalPublications');
            break;

        case 'events':
            $columns = 4; // event columns are hard set
            if ($block->input('override_event')) {
                $items = $block->getRelated('events');

                $items = $items->filter(function ($event) {
                    return $event->is_future;
                })->values()->take(4);

            } else {
                $items = \App\Models\Event::today()->future()->published()->notPrivate()->limit(4)->get();
            }
            break;

        case 'exhibitions':
            if ($block->input('override_exhibition')) {
                $exhibitions = $block->browserIds('exhibitions');
                $items = \App\Models\Api\Exhibition::query()->findMany($exhibitions)->sortBy('aic_start_at');
            } else {
                $items = \App\Models\Api\Exhibition::query()->current()->orderBy('aic_start_at', 'desc')->limit($columns)->get(['id', 'aic_start_at', 'aic_end_at', 'public_start_date', 'public_end_date']);
            }
            break;

        case 'experiences':
            $items = $block->getRelated('experiences');
            break;

        case 'highlights':
            $items = $block->getRelated('highlights');
            break;

        case 'videos':
            $items = $block->getRelated('videos');
            break;

        default:
            $items = [];
    }

@endphp

@if (count($items) > 0)
    <div class="m-feature-block-heading">
        @if ($heading)
            <h2 id="{{ StringHelpers::getUtf8Slug($heading) }}" class="title f-module-title-2">{{ $heading }}</h2>
        @endif
        @if ($browseLink && $browseLabel)
        <a href="{{ $browseLink }}">
            <h3 class="f-link">{{ $browseLabel }}
                <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
            </h3>
        </a>
        @endif
    </div>
    <hr/>
    <div class="m-feature-block columns-{{ $columns }}x">
        <ul class="m-feature-block-row column-{{ $columns }}x">
            @foreach($items as $index => $item)
                <li class="m-feature-block-listing column-{{ $columns }}x">
                    <a href="{{ $item->url_without_slug }}" class="m-feature-block-listing_link">
                        <div class="m-feature-block-listing__img__wrapper {{$ratio}}">
                            @if ($item->type === 'highlight')
                                <span class="m-feature-block-listing__img__overlay">
                                    <svg class="icon--slideshow--24"><use xlink:href="#icon--slideshow--24"></use></svg>
                                </span>
                            @endif
                            @if ($item->type === 'experience')
                                <span class="m-feature-block-listing__img__overlay">
                                    <svg class="icon--closer-look"><use xlink:href="#icon--closer-look"></use></svg>
                                </span>
                            @endif
                            @if($item->imageFront('listing') ?? $item->imageFront('hero'))
                                @component('components.atoms._img')
                                @slot('class', 'm-feature-block-listing__img column-' . $columns . 'x')                                
                                @slot('image', $item->imageFront('listing') ?? $item->imageFront('hero'))
                                    @slot('settings', array(
                                        'fit' => 'crop',
                                        'ratio' => '16:9',
                                        'srcset' => array(300,600,800,1200,1600),
                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                            'xsmall' => 58,
                                            'small' => 58,
                                            'medium' => 58,
                                            'large' => 38,
                                            'xlarge' => 38,
                                        ))))
                                @endcomponent
                                @if ($item->type === 'exhibition' && ($item->is_now_open || $item->is_closing_soon || $item->is_ongoing))                                
                                <div class="m-feature-block-listing__label__overlay">
                                    <span class="{{$item->is_now_open ? 'label-open' : ''}} {{$item->is_closing_soon ? 'label-closing' : ''}}">
                                        {{ $item->is_now_open ? 'Now Open' : ($item->is_closing_soon ? 'Closing Soon' : '') }}
                                    </span>
                                </div>
                                @endif
                            @else
                                <span class='default-img m-feature-block-listing__img column-{{$columns}}x'></span>
                            @endif
                        </div>
                        <span class="m-feature-block-listing__meta {{$item->type ? "l-type-$item->type" : ""}}">
                            @if ($item->type && $item->type !== 'experience' && $item->type !== 'exhibition' && $item->type !== 'event')
                                <em class="type f-tag">{{ $item->type }}</em>
                            @elseif( $item->type === 'experience' )
                                <em class="type f-tag">Interactive Feature</em>
                            @elseif( $feature_type === 'videos')
                                <em class="type f-tag">Video</em>
                            @endif
                            <strong class="title f-list-3">{!! $item->present()->title_display ?? $item->present()->title !!}</strong>
                            @if ($item->publish_start_date)
                                <span class="date f-secondary">{{ $item->present()->date_display_override }}</span>
                            @endif
                            <span class="m-feature-block-listing__meta-bottom">
                                @component('components.atoms._date')
                                @if(!$item->is_ongoing)
                                    @if ($item->present()->formattedNextOccurrence) 
                                        {!! $item->present()->formattedNextOccurrence !!}
                                    @elseif($item->present()->nextOccurrenceTime)
                                        {!! $item->present()->nextOccurrenceTime !!}
                                    @else
                                        {!! $item->present()->formattedDate !!}
                                    @endif
                                @endif
                                @endcomponent
                            </span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
