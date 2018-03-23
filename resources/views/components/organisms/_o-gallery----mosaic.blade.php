<div class="o-gallery o-gallery--mosaic{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($title))
        <h3 class="o-gallery__title f-module-title-2">{!! $title !!}</h3>
    @endif
    @if (!empty($allLink))
    <p class="o-gallery__all-link f-buttons">
        @component('components.atoms._arrow-link')
            @slot('href', $allLink['href'])
            {{ $allLink['label'] }}
        @endcomponent
    </p>
    @endif
    <div class="o-gallery__caption">
        @component('components.atoms._hr')
        @endcomponent
        @if (isset($caption))
            @component('components.blocks._text')
                @slot('font','f-caption')
                {!! $caption !!}
            @endcomponent
        @endif
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast-secondary btn--icon o-gallery__share')
            @slot('font', '')
            @slot('icon', 'icon--share--24')
            @slot('behavior','sharePage')
        @endcomponent
    </div>
    <div class="o-gallery__media o-gallery__media--2-col@small  o-gallery__media--2-col@medium  o-gallery__media--2-col@large  o-gallery__media--2-col@xlarge" data-behavior="pinboard">
        @if (isset($items) && !empty($items))
            @foreach ($items as $item)
                @component('components.molecules._m-media')
                    @slot('item', $item)
                    @slot('imageSettings', $imageSettings ?? '')
                @endcomponent
            @endforeach
        @endif
    </div>
    @if (!empty($allLink))
    <p class="o-gallery__all-link-btn">
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast')
            @slot('tag', 'a')
            @slot('href', $allLink['href'])
            {{ $allLink['label'] }}
        @endcomponent
    </p>
    @endif
</div>
