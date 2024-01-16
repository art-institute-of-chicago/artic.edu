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

@if (method_exists($item, 'hasFeaturedRelated') && $item->hasFeaturedRelated())
    <aside class="m-inline-aside{{ (isset($variation)) ? ' '.$variation : '' }}" {!! (isset($behavior)) ? 'data-behavior="'.$behavior.'"' : '' !!}>
        @component('components.atoms._hr')
        @endcomponent
        @component('components.blocks._text')
            @slot('font', 'f-module-title-1')
            @slot('tag', 'h4')
            {{ $item->getFeaturedRelatedTitle() }}
        @endcomponent
        @component('components.organisms._o-row-listing')
            @foreach ($item->getFeaturedRelated() as $related)
                @component('components.molecules._m-listing----' . strtolower($related['type']))
                    @slot('item', $related['item'])
                    @slot('variation',  $listingVariation)
                    @slot('fullscreen', false)
                    @slot('titleFont', $loop->index > 0 ? 'f-list-1' : 'f-list-3')
                    @slot('hideImage', $loop->index > 0)
                    @slot('hideDescription', $loop->index > 0)
                    @slot('imageSettings', $imageSettings ?? null)
                    @slot('gtmAttributes', $item->getFeaturedRelatedGtmAttributes())
                @endcomponent
            @endforeach
        @endcomponent
    </aside>
@endif
