@php
    $header = $block->input('header');
    $mediaType = $block->input('media_type');
    $media = $block->imageAsArray('image', 'desktop');
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
        @component('components.molecules._m-media')
            @slot('variation', 'm-showcase-media')
            @slot('item', [
                'type' => $mediaType,
                'media' => $media,
                'caption' => $media['caption'],
                'loop' => true,
                'loop_or_once' => 'loop',
            ])
        @endcomponent
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
