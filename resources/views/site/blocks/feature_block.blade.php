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
                $model = new \App\Models\Event();
                $items = $block->getRelated('events');

                foreach ($items as $key => $event) {
                    $eventWithMetas = $event->is_future;

                    if (!$eventWithMetas) {
                        unset($items[$key]);
                    }
                }

            } else {
                $items = \App\Models\Event::first()->published()->limit(4)->get();
            }
            break;

        case 'exhibitions':
            if ($block->input('override_exhibition')) {
                $exhibitions = $block->browserIds('exhibitions');
                $items = \App\Models\Exhibition::whereIn('datahub_id', $exhibitions)->orderBy('public_start_date', 'ASC')->get();
            } else {
                $items = \App\Models\Exhibition::first()->published()->limit(4)->get();
            }
            break;

        case 'experiences':
            $items = $block->getRelated('experiences');
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
                    <a href="{{ $item->getUrlWithoutSlugAttribute() }}" class="m-feature-block-listing_link">
                        @if($item->imageFront('listing') ?? $item->imageFront('hero'))
                            @component('components.atoms._img')
                            @slot('class', 'm-feature-block-listing__img ' . ($ratio ?? '') . ' column-' . $columns . 'x')
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
                        @else
                        <span class='default-img m-feature-block-listing__img {{$ratio}} column-{{$columns}}x'></span>
                        @endif
                        <span class="m-feature-block-listing__meta">
                            @if ( $item->type )
                                <em class="type f-tag">{{ $item->type }}</em>
                            @endif
                            @if ($item->present()->exhibitionType)
                                <em class="type f-tag">{{ $item->present()->exhibitionType}}</em>
                            @endif
                            @if ($item->title)
                                <strong class="title f-list-3">{{ $item->title }}</strong>
                            @endif
                            @if ($item->publish_start_date)
                                <span class="date f-secondary">{{ $item->present()->date_display_override }}</span>
                            @endif
                            <span class="m-feature-block-listing__meta-bottom">
                                @component('components.atoms._date')
                                @if ($item->present()->formattedNextOccurrence) 
                                    {!! $item->present()->formattedNextOccurrence !!}
                                @else
                                    {!! $item->present()->nextOccurrenceTime !!}
                                @endif
                            @endcomponent
                            </span>

                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
