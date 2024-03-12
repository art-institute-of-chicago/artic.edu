@php
    $heading = $block->present()->input('heading');
    $mediaType = $block->input('media_type');
    $media = $block->imageAsArray('image', 'desktop');
    $title = $block->present()->input('title');
    $description = $block->present()->input('description');
    $date = $block->present()->input('date');
    $tag = $block->input('tag');
    $linkLabel = $block->present()->input('link_label');
    $linkUrl = $block->input('link_url');
    $theme = $block->input('theme');
    $variation = $block->input('variation');
@endphp

<div id="{{ str(strip_tags($heading))->kebab() }}" class="m-showcase-block {{ $theme ? 'showcase--'.$theme : '' }} {{ $variation ? 'showcase--variation-'.$variation : '' }}">
    <div class="m-showcase-wrapper">
        @if ($heading)
            <h3 id="{{ Str::slug(strip_tags($heading)) }}" class="showcase-header">{!! $heading !!}</h3>
        @endif
        @if ($theme == 'rlc')
            @component('components.molecules._m-media')
                @slot('variation', 'm-showcase-media')
                @slot('item', [
                    'type' => $mediaType,
                    'media' => $media,
                    'loop' => true,
                    'loop_or_once' => 'loop',
                ])
            @endcomponent
        @else
            @component('components.atoms._img')
                @slot('image', $media)
                @slot('settings', $imageSettings ?? '')
                @slot('class', 'm-showcase-image')
            @endcomponent
        @endif
        <div class="m-showcase-block__text-wrapper">
            @if ($tag)
                @component('components.atoms._title')
                    @slot('tag', 'span')
                    @slot('font', 'f-tag')
                    @slot('variation', 'showcase-tag')
                    @slot('title', $tag)
                @endcomponent
            @endif
            @if ($title)
                @component('components.atoms._title')
                    @slot('tag', 'div')
                    @slot('font', 'f-headline-editorial')
                    @slot('variation', 'showcase-title')
                    @slot('title', $title)
                @endcomponent
            @endif
            @if ($description)
                @component('components.blocks._text')
                    @slot('tag', 'div')
                    @slot('font', 'f-secondary')
                    @slot('variation', 'showcase-description')
                    {!! SmartyPants::defaultTransform($description) !!}
                @endcomponent
            @endif
            @if ($date && ($theme == 'rlc' && $variation == 'default'))
                @component('components.blocks._text')
                    @slot('tag', 'div')
                    @slot('font', 'f-secondary')
                    @slot('variation', 'showcase-date')
                    {!! SmartyPants::defaultTransform($date) !!}
                @endcomponent
            @endif
            @if ($linkLabel || $linkUrl)
                @component('components.atoms._link')
                    @slot('font', 'f-secondary')
                    @slot('href', $linkUrl)
                    @slot('variation', 'showcase-link')
                    {!! SmartyPants::defaultTransform($linkLabel) !!} <svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg>
                @endcomponent
            @endif
        </div>
    </div>
</div>
