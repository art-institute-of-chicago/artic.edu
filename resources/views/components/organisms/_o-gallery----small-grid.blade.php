<div class="o-gallery o-gallery--small-grid o-gallery--grid{{ (isset($variation)) ? ' '.$variation : '' }}{{ empty($title) ? ' o-gallery----headerless' : '' }}">
    @if (!empty(strip_tags($title)))
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
    @if (!empty(strip_tags($title)) && !empty(strip_tags($caption)))
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
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_xsmall','1')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @foreach ($items as $item)
            @component('components.molecules._m-listing----grid-item')
                @slot('url', $item->url ?? '')
                @slot('image', ['src' => $item->thumbnail_url ?? ''])
                @slot('title', $item->title ?? '')
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => '216px',
                        'small' => '216px',
                        'medium' => '18',
                        'large' => '13',
                        'xlarge' => '13',
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
