@php
    $header = $block->input('header');
    $intro = $block->input('intro');
    $theme = $block->input('theme');
    $variation = $block->input('variation');

    // In the case of a variation swap for multiple we want to limit the number of items to 3 to fit design

    if ($variation === 'experience-with-us' || $variation === 'make-with-us') {
        $block->childs = $block->childs->sortBy('sort_order')->take(3);
    } 
@endphp

<div class="m-showcase-block showcase--multiple {{ $theme ? 'showcase--'.$theme : '' }} {{ $theme === 'default' ? '' : ($variation ? 'showcase--variation-'.$variation : '') }}">    <div class="m-showcase-background">
        <div class="m-showcase-wrapper">
            <div class="m-showcase-block__header-wrapper">
                @if ($header)
                    <h3 class="showcase-header">{{ $header }}</h3>
                @endif
                @if ($intro)
                    <h4 class="showcase-intro">{{ $intro }}</h4>
                @endif
            </div>
            @foreach ($block->childs as $item)
                @if ($item->input('media_type') == 'video')
                    @component('components.atoms._video')
                        @slot('video', ['src' => $item->file('video')])
                        @slot('controls', true)
                        @slot('class', 'm-showcase-video')
                    @endcomponent
                @else
                    @component('components.atoms._img')
                        @slot('image', $item->imageAsArray('image', 'desktop'))
                        @slot('class', 'm-showcase-image')
                    @endcomponent
                @endif
                <div class="m-showcase-block__text-wrapper">
                    @if ($tag = $item->input('tag'))
                        @component('components.atoms._title')
                            @slot('tag', 'span')
                            @slot('font', 'f-tag')
                            @slot('variation', 'showcase-tag')
                            @slot('title', $tag)
                        @endcomponent
                    @endif
                    @if ($title = $item->input('title'))
                        @component('components.atoms._title')
                            @slot('tag', 'div')
                            @slot('font', 'f-headline-editorial')
                            @slot('variation', 'showcase-title')
                            @slot('title', $title)
                        @endcomponent
                    @endif
                    @if ($description = $item->input('description'))
                        @component('components.blocks._text')
                            @slot('tag', 'div')
                            @slot('font', 'f-secondary')
                            @slot('variation', 'showcase-description')
                            {!! SmartyPants::defaultTransform($description) !!}
                        @endcomponent
                    @endif
                    @php
                        $linkLabel = $item->input('link_label');
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
