@php
    $imageSettings = $imageSettings ?? array(
        'fit' => 'crop',
        'ratio' => '16:9',
        'srcset' => array(200,400,600),
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

@endphp

@if (method_exists($item, 'hasFeaturedRelated') && $item->hasFeaturedRelated() || count($autoRelated) > 0)
    <aside class="m-inline-aside{{ (isset($variation)) ? ' '.$variation : '' }}" {!! (isset($behavior)) ? 'data-behavior="'.$behavior.'"' : '' !!}>
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-module-title-1')
            @slot('tag', 'h4')
            {{ $item->getFeaturedRelatedTitle() }}
        @endcomponent
        @component('components.organisms._o-row-listing')
            @foreach ($featuredRelated->concat($autoRelated)->take(6) as $related)
                @php
                    $isFeatured = $loop->first;
                @endphp
                @component('components.molecules._m-listing----auto-related')
                    @slot('isFeatured', $isFeatured)
                    @slot('item', $related['item'] ?? $related)
                    @slot('variation',  $listingVariation)
                    @slot('fullscreen', false)
                    @slot('titleFont', $isFeatured ? 'f-list-3' : 'f-list-1')
                    @slot('hideImage', $loop->index > 0)
                    @slot('hideDescription', $loop->index > 0)
                    @slot('imageSettings', $imageSettings ?? null)
                    @slot('gtmAttributes', $isFeatured ? ($item->getFeaturedRelatedGtmAttributes() ?? null) : (method_exists($related, 'getFeaturedRelatedGtmAttributes') ? $related->getFeaturedRelatedGtmAttributes() : null))
                @endcomponent
            @endforeach
        @endcomponent
    </aside>
@endif
