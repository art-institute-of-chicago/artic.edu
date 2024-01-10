@php
    $header = $block->input('header');
    $mediaType = $block->input('media_type');
    $image = $block->imageAsArray('image', 'desktop');
    $video = $block->file('video');
    $title = $block->input('title');
    $description = $block->input('description');
    $tag = $block->input('tag');
    $linkLabel = $block->input('link_label');
    $linkUrl = $block->input('link_url');
@endphp

<div id="{{ str(strip_tags($header))->kebab() }}" class="m-showcase-block">
    <div class="m-showcase-wrapper">
        @if ($header)
            <h3 class="showcase-header">{{ $header }}</h3>
        @endif
        @if ($mediaType == 'video')
            @component('components.atoms._video')
                @slot('video', ['src' => $video])
                @slot('class', 'm-showcase-video')
            @endcomponent
        @else
            @component('components.atoms._img')
                @slot('image', $image)
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
