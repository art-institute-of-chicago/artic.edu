@php
    $variations = [
        'grid-cards' => 6,
        'grid-year' => 3,
        'list-rows' => 1,
    ];

    $variationKey = array_key_exists($variation ?? '', $variations) ? $variation : 'grid-cards';

    $items = collect($items ?? []);

    $limit = $limit ?? $variations[$variationKey];
    $total = $total ?? $items->count();
    $id = $id ?? (\Illuminate\Support\Str::slug($label) ?: 'related-content');
    $seeAllLabel = $seeAllLabel ?? \Illuminate\Support\Str::lower($label);
    $capped = $items->count() > $limit;

    // Capped lists render the first `$limit` items inline; the overflow moves
    // into an accordion panel handled by the shared accordion behavior.
    $mainItems = $capped ? $items->take($limit) : $items;
    $overflowItems = $capped ? $items->slice($limit)->values() : collect();

    // Raw content mode: when a caller passes a non-empty body slot instead of
    // items, render the section chrome plus the slot, without meta/list.
    $hasRawContent = $items->isEmpty()
        && isset($slot)
        && is_object($slot)
        && method_exists($slot, 'isEmpty')
        && !$slot->isEmpty();

    $rawVariation = isset($variation) && $variation !== '' ? $variation : $variationKey;

    $gtmAttributes = $gtmAttributes ?? 'data-gtm-event="see-all-related-content" data-gtm-event-category="collection-nav"';

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
@endphp

@if ($hasRawContent)
    <section class="o-related-content o-related-content--{{ $rawVariation }}" aria-labelledby="{{ $id }}-title">
        <h2 id="{{ $id }}-title" class="o-related-content__label f-module-title-2">{{ $label }}</h2>

        <div class="o-related-content__main">
            {!! $slot !!}
        </div>
    </section>
@elseif ($items->isNotEmpty())
    <section class="o-related-content o-related-content--{{ $variationKey }}"{!! $capped ? ' data-behavior="accordion"' : '' !!} aria-labelledby="{{ $id }}-title">
        <h2 id="{{ $id }}-title" class="o-related-content__label f-module-title-2">{{ $label }}</h2>

        <div class="o-related-content__main">
            <div class="o-related-content__meta">
                <span class="o-related-content__count f-secondary">{{ $total }} total</span>

                @if ($capped)
                    <button type="button" class="o-related-content__toggle f-link o-accordion__trigger" aria-expanded="false" aria-controls="{{ $id }}-panel" {!! $gtmAttributes !!}>
                        <span class="o-related-content__toggle-label o-related-content__toggle-label--open">See all {{ $seeAllLabel }}</span>
                        <span class="o-related-content__toggle-label o-related-content__toggle-label--close">Show less</span>
                        <svg class="icon--plus" aria-hidden="true"><use xlink:href="#icon--plus"></use></svg>
                        <svg class="icon--minus" aria-hidden="true"><use xlink:href="#icon--minus"></use></svg>
                    </button>
                @endif
            </div>

            <ul id="{{ $id }}-list" class="o-related-content__list">
                @foreach ($mainItems as $relatedItem)
                    @include('components.organisms._o-related-content-item', ['relatedItem' => $relatedItem, 'variation' => $variationKey, 'imageSettings' => $imageSettings])
                @endforeach
            </ul>

            @if ($capped)
                <div class="o-related-content__panel o-accordion__panel" id="{{ $id }}-panel" aria-hidden="true" aria-labelledby="{{ $id }}-title">
                    <ul class="o-related-content__list">
                        @foreach ($overflowItems as $relatedItem)
                            @include('components.organisms._o-related-content-item', ['relatedItem' => $relatedItem, 'variation' => $variationKey, 'imageSettings' => $imageSettings])
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endif
