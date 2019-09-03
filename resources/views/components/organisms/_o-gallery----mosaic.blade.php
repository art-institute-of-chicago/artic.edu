<div class="o-gallery o-gallery--mosaic{{ (isset($variation)) ? ' '.$variation : '' }}{{ empty($title) && empty($caption) ? ' o-gallery----headerless' : '' }}">
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
    @if (!empty($caption))
        <div class="o-gallery__caption">
            @component('components.atoms._hr')
            @endcomponent
            @component('components.blocks._text')
                @slot('font','f-caption')
                {!! $caption !!}
            @endcomponent
        </div>
    @endif
    <div class="o-gallery__media o-gallery__media--2-col@small  o-gallery__media--2-col@medium  o-gallery__media--2-col@large  o-gallery__media--2-col@xlarge" data-behavior="pinboard">
        @if (isset($items) && !empty($items))
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
