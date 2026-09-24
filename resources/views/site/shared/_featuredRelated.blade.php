@php
    $imageSettings = $imageSettings ?? array(
        'fit' => 'crop',
        'ratio' => '16:9',
        'srcset' => ImageHelpers::SRCSET_WIDTHS_SMALL,
        'sizes' => ImageHelpers::aic_imageSizes(array(
            'xsmall' => '58',
            'small' => '23',
            'medium' => '18',
            'large' => '13',
            'xlarge' => '13',
        )),
    );

    $listingVariation = 'm-listing--sidebar';

    if (($behavior ?? '') === 'relatedSidebar') {
        $listingVariation .= ' m-listing--dynamic';
    }

    // The auto-related artist page is an optional sidebar item. It is
    // prepended so it is always considered before the six-item cap is applied.
    $relatedArtistPage = $relatedArtistPage ?? null;

    $relatedItems = $featuredRelated->concat($autoRelated);

    if ($relatedArtistPage) {
        $relatedItems = $relatedItems->prepend($relatedArtistPage);
    }

    $relatedItems = $relatedItems->take(6);

    // The prepended artist page never takes the hero slot: the first
    // editorial item keeps the featured treatment.
    $featuredAssigned = false;
@endphp

@if (method_exists($item, 'hasFeaturedRelated') && $item->hasFeaturedRelated() || count($autoRelated) > 0 || $relatedArtistPage)
    <aside class="m-inline-aside{{ (isset($variation)) ? ' '.$variation : '' }}" {!! (isset($behavior)) ? 'data-behavior="'.$behavior.'"' : '' !!}>
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-module-title-1')
            @slot('tag', 'h4')
            {{ $item->getFeaturedRelatedTitle() }}
        @endcomponent
        @component('components.organisms._o-row-listing')
            @foreach ($relatedItems as $related)
                @php
                    $relatedItem = $related['item'] ?? $related;
                    $isArtistPage = $relatedArtistPage && $relatedItem === $relatedArtistPage;
                    $isFeatured = !$isArtistPage && !$featuredAssigned;
                    $featuredAssigned = $featuredAssigned || $isFeatured;
                @endphp
                @if ($relatedItem instanceof \App\Models\Api\Artist)
                    @component('components.molecules._m-listing----artist')
                        @slot('item', $relatedItem)
                        @slot('variation', $listingVariation)
                        @slot('titleFont', $isFeatured ? 'f-list-3' : 'f-list-1')
                        @slot('imageSettings', $imageSettings ?? null)
                        @slot('gtmAttributes', $isFeatured ? ($item->getFeaturedRelatedGtmAttributes() ?? null) : null)
                    @endcomponent
                @else
                    @component('components.molecules._m-listing----auto-related')
                        @slot('isFeatured', $isFeatured)
                        @slot('item', $relatedItem)
                        @slot('variation',  $listingVariation)
                        @slot('fullscreen', false)
                        @slot('titleFont', $isFeatured ? 'f-list-3' : 'f-list-1')
                        @slot('hideImage', $loop->index > 0)
                        @slot('hideDescription', $loop->index > 0)
                        @slot('imageSettings', $imageSettings ?? null)
                        @slot('gtmAttributes', $isFeatured ? ($item->getFeaturedRelatedGtmAttributes() ?? null) : (method_exists($related, 'getFeaturedRelatedGtmAttributes') ? $related->getFeaturedRelatedGtmAttributes() : null))
                    @endcomponent
                @endif
            @endforeach
        @endcomponent
    </aside>
@endif
