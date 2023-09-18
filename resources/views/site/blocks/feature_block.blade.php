@php

    // Persistent fields from CMS
    $heading = $block->input('feature_heading');
    $browseLabel = $block->input('browse_label');
    $browseLink = $block->input('browse_link');
    $ratio = $block->input('image_ratio');

    // Set feature type from options of 'custom', 'event', 'exhibition'
    $feature_type = $block->input('feature_type');
    $columns = 4;

    if ($feature_type === 'custom') {
        $items = $block->getRelated('content_type');
        $columns = $block->input('columns');
    } elseif ($feature_type === 'event') {
        if ($block->input('override_event')) {
            $model = new \App\Models\Event();
            $items = $block->getRelated('events');

            foreach ($items as $key => $event) {
                $eventWithMetas = $event->is_future;

                if (!$eventWithMetas) {
                    dump("unset");
                    unset($items[$key]);
                }
            }

        } else {
            $items = \App\Models\Event::first()->published()->limit(4)->get();
        }

    } elseif ($feature_type === 'exhibition') {
        if ($block->input('override_exhibition')) {
            $items = $block->relatedItems();
            dump($items);
        } else {
            $items = \App\Models\Exhibition::first()->published()->limit(4)->get();
            // exhibition date handling logic
            // order $items from model by date
        }
    }

@endphp

    

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
@if (isset($items))
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
                            <span class="default-img m-feature-block-listing__img {{$ratio ?? ''}}"></span>
                        @endif
                        <span class="m-feature-block-listing__meta">
                            @if ( $item->type )
                                <em class="type f-tag">{{ $item->type }}</em>
                            @endif
                            @if ($item->title)
                                <strong class="title f-list-3">{{ $item->title }}</strong>
                            @endif
                            @if ($item->publish_start_date)
                                <span class="date f-secondary">{{ $item->present()->date_display_override }}</span>
                            @endif
                            <span class="m-feature-block-listing__meta-bottom"></span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
