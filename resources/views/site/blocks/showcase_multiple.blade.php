@php
    $heading = $block->present()->input('heading');
    $intro = $block->present()->input('intro');
    $theme = $block->input('theme');
    $variation = $block->input('variation');
@endphp

<div id="{{ str(strip_tags($heading))->kebab() }}" class="m-showcase-multiple-block {{ $theme ? 'showcase--'.$theme : '' }} {{ $variation ? 'showcase--variation-'.$variation : '' }}">
    <div class="m-showcase-background">
        <div class="m-showcase-wrapper">
            <div class="m-showcase-block__header-wrapper">
                @if ($heading)
                    <h3 class="showcase-header">{!!$heading !!}</h3>
                @endif
                @if ($intro)
                    <h4 class="showcase-intro">{!! $intro !!}</h4>
                @endif
            </div>
            @foreach ($block->children as $item)
                @php
                    $media = $item->imageAsArray('image', 'desktop');
                @endphp
                @component('components.molecules._m-media')
                    @slot('variation', 'm-showcase-media')
                    @slot('item', [
                        'type' => $item->input('media_type'),
                        'media' => $media,
                        'loop' => true,
                        'loop_or_once' => 'loop',
                    ])
                @endcomponent
                <div class="m-showcase-block__text-wrapper">
                    @if ($tag = $item->input('tag'))
                        @component('components.atoms._title')
                            @slot('tag', 'span')
                            @slot('font', 'f-tag')
                            @slot('variation', 'showcase-tag')
                            @slot('title', $tag)
                        @endcomponent
                    @endif
                    @if ($title = $item->present()->input('title'))
                        @component('components.atoms._title')
                            @slot('tag', 'div')
                            @slot('font', 'f-headline-editorial')
                            @slot('variation', 'showcase-title')
                            @slot('title', $title)
                        @endcomponent
                    @endif
                    @if ($description = $item->present()->input('description'))
                        @component('components.blocks._text')
                            @slot('tag', 'div')
                            @slot('font', 'f-secondary')
                            @slot('variation', 'showcase-description')
                            {!! SmartyPants::defaultTransform($description) !!}
                        @endcomponent
                    @endif
                    @php
                        $linkLabel = $item->present()->input('link_label');
                        $linkUrl = $item->input('link_url');
                    @endphp
                    @if ($linkLabel || $linkUrl)
                        @component('components.atoms._link')
                            @slot('font', 'f-secondary')
                            @slot('href', $linkUrl)
                            @slot('variation', 'showcase-link')
                            {!! SmartyPants::defaultTransform($linkLabel) !!}
                            <svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg>
                        @endcomponent
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
