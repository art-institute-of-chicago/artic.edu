<{{ $tag or 'div' }} class="m-row-block{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($title) && isset($variation) && !strrpos($variation, "inline-title"))
        @component('components.blocks._text')
            @slot('font', $titleFont ?? 'f-module-title-1')
            @slot('variation', 'm-row-block__title')
            @slot('tag', 'h4')
            {{ $title }}
        @endcomponent
    @endif
    @if (isset($img))
        <div class="m-row-block__img">
            @component('components.atoms._img')
                @slot('image', $img)
                @slot('settings', $imageSettings ?? '')
            @endcomponent
        </div>
    @endif
    @if (isset($text))
        <div class="m-row-block__text">
            @if (isset($title) && isset($variation) && strrpos($variation, "inline-title"))
                @component('components.blocks._text')
                    @slot('font', $titleFont ?? 'f-module-title-1')
                    @slot('variation', 'm-row-block__title')
                    @slot('tag', 'h4')
                    {{ $title }}
                @endcomponent
            @endif
            @if (isset($text))
                @component('components.blocks._text')
                    @slot('font', $textFont ?? 'f-secondary')
                    {{ $text }}
                @endcomponent
            @endif
        </div>
    @endif
</{{ $tag or 'div' }}>
