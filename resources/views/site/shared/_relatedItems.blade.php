@if (isset($relatedItems) && $relatedItems)
    @component('components.molecules._m-title-bar')
        {{ $title }}
    @endcomponent
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($relatedItems as $item)
            @component('components.molecules._m-listing----' . strtolower($item->type))
                @slot('item', $item)
                @slot('subtype', $item->subtype ?? $item->type)
                @slot('hideDescription', $hideDescription ?? true)
                @slot('imgVariation', ' ')
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => '216px',
                        'small' => '216px',
                        'medium' => '18',
                        'large' => '13',
                        'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif
