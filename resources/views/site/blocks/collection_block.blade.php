@php
    use App\Helpers\GtmHelpers;

    $browserArtworks = $block->browserIds('artworks');
    $artworks = \App\Models\Api\Artwork::query()->ids($browserArtworks)->get();
    $heading = $block->input('collection_heading');
    $bottom_desc = $block->input('bottom_desc');
    $primary_button_label = $block->input('primary_button_label');
    $primary_button_link = $block->input('primary_button_link');
    $secondary_button_label = $block->input('secondary_button_label');
    $secondary_button_link = $block->input('secondary_button_link');

    $sizes = [
            'xsmall' => $sizes['xsmall'] ?? 2,
            'small' => $sizes['small'] ?? 2,
            'medium' => $sizes['medium'] ?? 3,
            'large' => $sizes['large'] ?? 4,
            'xlarge' => $sizes['xlarge'] ?? 4,
    ];

@endphp

<div class="m-collection-block">
    <div class="m-collection-heading">
        @if ($heading)
            <h2 id="{{ StringHelpers::getUtf8Slug($heading) }}" class="title f-module-title-2">{{ $heading }}</h2>
        @endif
        <div class="m-collection-slider-controls" data-behavior="">
            <button class="b-drag-scroll__btn-prev btn btn--transparent f-buttons arrow-link--back f-link"><svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></button>
            <button class="b-drag-scroll__btn-next btn btn--transparent f-buttons arrow-link f-link"><svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></button>
        </div>
    </div>
    <div class="m-collection-artworks" data-behavior="dragScroll">
        <div class="m-collection-row">
            @foreach ($artworks as $item)
                @if ($loop->odd)
                    @component('components.molecules._m-collection-block--artwork')
                        @slot('variation', 'm-collection-artwork__item')
                        @slot('item', $item)
                        @slot('imageSettings', array(
                            'fit' => null,
                            'ratio' => null,
                            'srcset' => ImageHelpers::aic_getSrcsetForImage($item->imageFront(), $item->is_public_domain ?? false),
                            'sizes' => ImageHelpers::aic_gridListingImageSizes($sizes),
                        ))
                        @slot('gtmAttributes', GtmHelpers::combineGtmAttributes([
                            GtmHelpers::getGtmAttributesForClickMetaDataEventOnArtwork($item),
                            isset($gtmAttributesForItem)
                                ? $gtmAttributesForItem($item, $loop)
                                : null,
                        ]))
                    @endcomponent
                @endif
            @endforeach
        </div>
        <div class="m-collection-row">
            @foreach ($artworks as $item)
                @if ($loop->even)
                    @component('components.molecules._m-collection-block--artwork')
                        @slot('variation', 'm-collection-artwork__item')
                        @slot('item', $item)
                        @slot('imageSettings', array(
                            'fit' => null,
                            'ratio' => null,
                            'srcset' => ImageHelpers::aic_getSrcsetForImage($item->imageFront(), $item->is_public_domain ?? false),
                            'sizes' => ImageHelpers::aic_gridListingImageSizes($sizes),
                        ))
                        @slot('gtmAttributes', GtmHelpers::combineGtmAttributes([
                            GtmHelpers::getGtmAttributesForClickMetaDataEventOnArtwork($item),
                            isset($gtmAttributesForItem)
                                ? $gtmAttributesForItem($item, $loop)
                                : null,
                        ]))
                    @endcomponent
                @endif
            @endforeach
        </div>
    </div>
    <div class="m-collection-bottom">
        @if ($bottom_desc)
            <div class="collection-desc">
                {!! $bottom_desc !!}
            </div>
            <div class="collection-btns">
                <a href="{{ $primary_button_link }}" class="btn f-buttons">{!! $primary_button_label !!}</a>
                <a href="{{ $secondary_button_link }}" class="btn f-buttons btn--secondary">{!! $secondary_button_label !!}</a>
            </div>
        @endif
    </div>
</div>
