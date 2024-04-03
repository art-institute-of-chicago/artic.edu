@php

    // Persistent fields from CMS
    $feature_heading = $block->input('feature_heading');
    $heading = $block->input('heading');
    $body = $block->input('body') ?? null;
    $browseLabel = $block->input('browse_label');
    $browseLink = $block->input('browse_link');
    $ratio = $block->input('image_ratio');

    $feature_type = $block->input('feature_type');
    $columns = $block->input('columns');

    $categories = collect($block->input('categories'))->take(12) ?? null;
    $tags = \App\Models\Category::whereIn('id', $categories)->get() ?? null;

    $theme = $block->input('theme');
    $variation = $block->input('variation');



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
    @if ($theme !== 'editorial')
        <div class="m-feature-block-heading">
            @if ($feature_heading)
                <h2 class="title f-module-title-2">{{ $feature_heading }}</h2>
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
    @else
        <div class="m-feature-block-editorial__header">
            <div class="editorial-block__heading">
                <h2 id="{{ StringHelpers::getUtf8Slug($heading) }}">{{ $heading }}</h2>
                @if ($variation == 'video')
                @component('components.atoms._link')
                    @slot('font', 'f-secondary')
                    @slot('href', route('articles', [], false))
                    @slot('variation', 'm-feature-block-editorial__link')
                    {!! SmartyPants::defaultTransform('View all videos') !!} <svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg>
                @endcomponent
                @endif
            </div>
            <div class="m-feature-block-editorial__body">
                {!! $body !!}
            </div>
            @if ( (isset($tags) && $tags) && $tags->count() > 0)
                <div class="m-feature-block-editorial__tags">
                    @foreach ($tags as $tag)
                        <a class="tag f-tag" href="{{ route('articles', ['category' => $tag->id]) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    @endif
        <div class="m-feature-block columns-{{ $columns }}x {{ $theme ? 'feature-block--'.$theme : '' }} {{ $variation ? 'feature-block--variation-'.$variation : '' }}">
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
