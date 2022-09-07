@unless ($artworks->isEmpty())
    @php
        $sizes = [
            'xsmall' => $sizes['xsmall'] ?? 2,
            'small' => $sizes['small'] ?? 2,
            'medium' => $sizes['medium'] ?? 3,
            'large' => $sizes['large'] ?? 4,
            'xlarge' => $sizes['xlarge'] ?? 4,
        ];
    @endphp
    @component('components.organisms._o-pinboard')
        @slot('id', $id ?? null)
        @slot('title', $title ?? null)
        @slot('maintainOrder','false')
        @foreach ($sizes as $breakpoint => $columnCount)
            @slot('cols_' . $breakpoint, $columnCount)
        @endforeach
        @foreach ($artworks as $item)
            @component('components.molecules._m-listing----artwork')
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => null,
                    'ratio' => null,
                    'srcset' => ImageHelpers::aic_getSrcsetForImage($item->imageFront(), $item->is_public_domain ?? false),
                    'sizes' => ImageHelpers::aic_gridListingImageSizes($sizes),
                ))
                @php
                    // WEB-2436: Support sending multiple events per click
                    $allGtmAttributesForItem = [
                        \App\Helpers\GtmHelpers::getGtmAttributesForClickMetaDataEventOnArtwork($item)
                    ];

                    // Passed via `slot` to this component
                    if (isset($gtmAttributesForItem)) {
                        $allGtmAttributesForItem[] = $gtmAttributesForItem($item, $loop);
                    }

                    $allGtmAttributesForItem = array_map(
                        function ($value, $index) {
                            return str_replace('-gtm-', '-gtm-' . $index . '-', $value);
                        },
                        $allGtmAttributesForItem,
                        array_keys($allGtmAttributesForItem)
                    );

                    $allGtmAttributesForItem = implode(' ', $allGtmAttributesForItem);
                @endphp
                @slot('gtmAttributes', $allGtmAttributesForItem)
            @endcomponent
        @endforeach
    @endcomponent
@endunless
