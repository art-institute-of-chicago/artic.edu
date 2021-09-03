<div class="o-gallery o-gallery--slider{{ (isset($variation)) ? ' '.$variation : '' }}{{ empty($title) ? ' o-gallery----headerless' : '' }}">
    <div class="clearfix"></div>
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
                @slot('font', 'f-caption')
                @slot('tag', 'div')
                {!! $caption !!}
            @endcomponent
        </div>
    @endif
    <div class="o-gallery--slider__controls" aria-hidden="true">
        <button class="b-drag-scroll__btn-prev btn btn--transparent f-buttons arrow-link arrow-link--back f-link"><svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></button>
        <button class="b-drag-scroll__btn-next btn btn--transparent f-buttons arrow-link f-link"><svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></button>
    </div>
    <div class="o-gallery__media-wrapper">
        <div class="o-gallery__media" data-behavior="dragScroll">
            @component('site.shared._mediaitems')
                @slot('items', $items)
                @slot('imageSettings', $imageSettings ?? array(
                    'srcset' => array(200,400,600,1000,1500,3000),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => '50',
                        'small' => '35',
                        'medium' => '23',
                        'large' => '23',
                        'xlarge' => '18',
                    )),
                ))
            @endcomponent
        </div>
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
