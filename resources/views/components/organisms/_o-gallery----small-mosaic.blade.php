<div class="o-gallery o-gallery--small-mosaic o-gallery--mosaic{{ (isset($variation)) ? ' '.$variation : '' }}{{ empty($title) ? ' o-gallery----headerless' : '' }}">
    @if (!empty($title))
        <h3 id="{{ Str::slug(html_entity_decode($title)) }}" class="o-gallery__title f-module-title-2">{!! $title !!}</h3>
    @endif
    @if (!empty($allLink))
    <p class="o-gallery__all-link f-buttons">
        @component('components.atoms._arrow-link')
            @slot('href', $allLink['href'])
            {{ $allLink['label'] }}
        @endcomponent
    </p>
    @endif
    @if (!empty($title) && !empty($caption))
        <div class="o-gallery__caption">
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font','f-caption')
                @slot('tag', 'div')
                {!! $caption !!}
            @endcomponent
        </div>
    @endif
    @component('components.organisms._o-pinboard')
        @slot('id', 'mediaList')
        @slot('cols_xsmall','1')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('maintainOrder','false')
        @component('site.shared._mediaitems')
            @slot('items', $items)
            @slot('imageSettings', $imageSettings ?? array(
                'srcset' => array(200,400,600,1000,1500,3000),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '38',
                    'small' => '18',
                    'medium' => '18',
                    'large' => '18',
                    'xlarge' => '11',
                )),
            ))
        @endcomponent
    @endcomponent
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
