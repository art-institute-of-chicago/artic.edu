<div class="m-row-block m-row-block---keyline-top">
    @if (isset($title))
        @component('components.blocks._text')
            @slot('font', 'f-module-title-1')
            @slot('variation', 'm-row-block__title')
            @slot('tag', 'h4')
            {{ $title }}
        @endcomponent
    @endif
    @if (isset($img))
        <div class="m-row-block__img">
            @component('components.atoms._img')
                @slot('src', $img['src'] ?? '')
                @slot('srcset', $img['srcset'] ?? '')
                @slot('sizes', $img['sizes'] ?? '')
                @slot('width', $img['width'] ?? '')
                @slot('height', $img['height'] ?? '')
            @endcomponent
        </div>
    @endif
    @if (isset($text))
        <div class="m-row-block__text">
            @component('components.blocks._text')
                @slot('font', 'f-secondary')
                {{ $text }}
            @endcomponent
        </div>
    @endif
</div>
