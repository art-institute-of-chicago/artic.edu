<div class="o-gallery o-gallery--slider{{ (isset($variation)) ? ' '.$variation : '' }}{{ empty($title) ? ' o-gallery----headerless' : '' }}">
    @if (!empty($title))
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
    @if (!empty($title) && !empty($caption))
        <div class="o-gallery__caption">
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font','f-caption')
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
            @if (isset($items))
                @foreach ($items as $item)
                    @php
                        $currentImageSettings = $imageSettings;
                        if (($item['isArtwork'] ?? false) && !($item['isPublicDomain'] ?? false))
                        {
                            $currentImageSettings['srcset'] = array_values(
                                array_filter($currentImageSettings['srcset'], function($size) {
                                    return $size < 843;
                                })
                            );
                        }
                    @endphp
                    @component('components.molecules._m-media')
                        @slot('item', $item)
                        @slot('imageSettings', $currentImageSettings ?? '')
                    @endcomponent
                @endforeach
            @endif
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
