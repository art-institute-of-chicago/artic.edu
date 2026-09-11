@php
    use App\Helpers\GtmHelpers;

    $headingPrefix = $headingPrefix ?? '';
    $maxItems = $maxItems ?? 12;
    $headingLinkText = $headingLinkText ?? null;
    $headingUrl = $headingUrl ?? null;

    $sizes = [
        'xsmall' => $sizes['xsmall'] ?? 2,
        'small' => $sizes['small'] ?? 2,
        'medium' => $sizes['medium'] ?? 3,
        'large' => $sizes['large'] ?? 4,
        'xlarge' => $sizes['xlarge'] ?? 4,
    ];

    $carouselItems = $items ?? collect([]);

    if (!$carouselItems instanceof \Illuminate\Support\Collection) {
        $carouselItems = collect($carouselItems);
    }

    // Keep only items that actually have an image so no 0-width gaps break the rows.
    $carouselItems = $carouselItems->filter(function ($item) {
        return !empty($item->imageFront());
    })->take($maxItems);

    // Precompute each artwork's rendered width (fixed row height => width scales
    // with the image aspect ratio) so items can be distributed across the two
    // rows by width.
    $carouselEntries = $carouselItems->map(function ($item) {
        $image = $item->imageFront();
        $w = $image['width'] ?? null;
        $h = $image['height'] ?? null;
        $ratio = ($w && $h) ? ($w / $h) : 1.2;

        return (object) [
            'item' => $item,
            'image' => $image,
            'width' => (300 * $ratio) + 40,
        ];
    })->values();

    // Greedy load-balance into two rows. Source order is respected while sums
    // are near equal; a wide artwork tips the balance and later items simply
    // flow into the shorter row, so wide pieces don't drag one row far past the
    // other.
    $carouselRows = [collect(), collect()];
    $carouselRowSums = [0, 0];

    foreach ($carouselEntries as $entry) {
        $target = ($carouselRowSums[0] <= $carouselRowSums[1]) ? 0 : 1;

        if (
            $carouselRowSums[0] === $carouselRowSums[1] &&
            $carouselRows[0]->count() > $carouselRows[1]->count()
        ) {
            $target = 1;
        }

        $carouselRows[$target]->push($entry);
        $carouselRowSums[$target] += $entry->width;
    }
@endphp

@if ($carouselItems->count() > 1)
    <div class="m-collection-block o-collection-carousel">
        <div class="m-collection-wrapper">
            <div class="m-collection-heading">
                <h2 class="title f-module-title-2">{{ $headingPrefix }}@if (!empty($headingUrl) && !empty($headingLinkText))<a href="{{ $headingUrl }}" class="o-collection-carousel__heading-link">{{ $headingLinkText }}</a>@else{{ $headingLinkText }}@endif</h2>
                <div class="m-collection-slider-controls" data-behavior="">
                    <button class="b-drag-scroll__btn-prev btn btn--transparent f-buttons arrow-link--back f-link"><svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></button>
                    <button class="b-drag-scroll__btn-next btn btn--transparent f-buttons arrow-link f-link"><svg class="icon--arrow"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow--24"></use></svg></button>
                </div>
            </div>
            <div class="m-collection-content">
                <div class="m-collection-artworks" data-behavior="dragScroll">
                    @foreach ($carouselRows as $carouselRow)
                    <div class="m-collection-row">
                        @foreach ($carouselRow as $carouselEntry)
                            @component('components.molecules._m-collection-block--artwork')
                                @slot('variation', 'm-collection-artwork__item')
                                @slot('item', $carouselEntry->item)
                                @slot('imageSettings', array(
                                    'fit' => null,
                                    'ratio' => null,
                                    'srcset' => ImageHelpers::aic_getSrcsetForImage($carouselEntry->image, $carouselEntry->item->is_public_domain ?? false),
                                    'sizes' => ImageHelpers::aic_gridListingImageSizes($sizes),
                                ))
                                @slot('gtmAttributes', GtmHelpers::combineGtmAttributes([
                                    GtmHelpers::getGtmAttributesForClickMetaDataEventOnArtwork($carouselEntry->item),
                                ]))
                            @endcomponent
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
