@php

    $heading = $block->input('stories_heading');
    $browseLabel = $block->input('browse_label');
    $browseLink = $block->input('browse_link');
    $items = $block->getRelated('content');

@endphp

@if (count($items) > 0)
    <div class="m-stories-block">
        <div class="m-stories-heading">
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
        <div class="m-stories-grid">
            @foreach($items as $item)
                @if($loop->iteration === 2 && $loop->count > 1)
                    <div class="m-stories-column">
                @endif
                <div class={{ $loop->iteration > 1 ? 'm-side-story' : 'm-featured-story' }}>
                    <a href="{{ $item->url_without_slug }}" class="m-story__link">
                        @if($item->imageFront('listing') ?? $item->imageFront('hero'))
                            @component('components.atoms._img')
                            @slot('class', 'm-story-listing__img ')
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
                            <span class='default-img m-story-listing__img'></span>
                        @endif
                        @if($item->type && $item->type !== 'video' && $item->type !== 'experience')
                            <em class="type f-tag">{{$item->type}}</em>
                        @elseif($item->video_url)
                            <em class="type f-tag">Video</em>
                        @elseif($item->type === 'experience')
                            <em class="type f-tag">Interactive Feature</em>
                        @endif
                        @if($item->title_display || $item->title)
                            <strong class="title f-list-3">{!! $item->present()->title_display ?? $item->present()->title !!}</strong>
                        @endif
                        @if($loop->first)
                            <span class="intro f-body-editorial">{!! $item->present()->list_description !!}</span>
                        @endif
                    </a>
                </div>
                @if($loop->last && $loop->count > 1)
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif