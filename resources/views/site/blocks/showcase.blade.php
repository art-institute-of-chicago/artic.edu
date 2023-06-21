@php
    $image = $block->imageAsArray('image', 'desktop');

    $title = $block->input('title');
    $description = $block->input('description');
    $tag = $block->input('tag');
@endphp

<div class="m-showcase-block">
    @component('components.atoms._img')
        @slot('image', $image)
        @slot('settings', $imageSettings ?? '')
    @endcomponent
    <div class="m-showcase-block__text-wrapper">
        @component('components.atoms._title')
            @slot('tag', 'span')
            @slot('font', 'f-tag')
            @slot('variation', 'showcase-tag')
            @slot('title', $tag)
        @endcomponent
        @component('components.atoms._title')
            @slot('tag', 'div')
            @slot('font', 'f-headline-editorial')
            @slot('variation', 'showcase-title')
            @slot('title', $title)
        @endcomponent
        @component('components.atoms._title')
            @slot('tag', 'div')
            @slot('font', 'f-secondary')
            @slot('variation', 'showcase-subtitle')
            @slot('title', $subtitle)
        @endcomponent
    </div>
</div>
    