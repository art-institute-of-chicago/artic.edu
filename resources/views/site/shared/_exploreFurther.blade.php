@unless ($artworks->isEmpty())
    @component('components.organisms._o-pinboard')
        @slot('cols_small','2')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('maintainOrder','false')
        @slot('id','explore-further-pinboard')
        @slot('title', 'Artworks related to tag')
        @foreach ($artworks as $item)
            @component('components.molecules._m-listing----'.strtolower($item->type))
                @slot('variation', 'o-pinboard__item')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                    'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                    'srcset' => array(200,400,600),
                    'sizes' => aic_gridListingImageSizes(array(
                        'xsmall' => '1',
                        'small' => '2',
                        'medium' => '3',
                        'large' => '4',
                        'xlarge' => '4',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endunless
