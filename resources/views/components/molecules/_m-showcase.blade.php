<div class="m-showcase {{ $variation ? $variation : ''}}">
    <div class="m-showcase-wrapper">
            <div class="m-showcase-media">
                <a href={{ $linkUrl }} class="showcase-link" >
                    @component('components.atoms._img')
                        @slot('image', $image)
                        @slot('settings', $imageSettings ?? '')
                        @slot('class', 'm-showcase-image')
                    @endcomponent
                </a>
            </div>
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
            <a href={{ $linkUrl }} class="showcase-link" >
                @component('components.atoms._title')
                    @slot('tag', 'div')
                    @slot('font', 'f-headline-editorial')
                    @slot('variation', 'showcase-title')
                    @slot('title', $title)
                @endcomponent
            </a>
            @endif
            @if ($author_display)
                <span class="f-secondary">by {{ $author_display }}</span>
            @endif
            @if ($description)
                <a href={{ $linkUrl }} class="showcase-link" >
                    @component('components.blocks._text')
                        @slot('tag', 'div')
                        @slot('font', 'f-secondary')
                        @slot('variation', 'showcase-description')
                        {!! SmartyPants::defaultTransform($description) !!}
                    @endcomponent
                </a>
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
