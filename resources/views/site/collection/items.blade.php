@foreach ($artworks as $item)
    @component('components.molecules._m-listing----'.$item->type)
        @slot('variation', 'o-pinboard__item')
        @slot('item', $item)
        @slot('imageSettings', array(
            'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
            'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
            'srcset' => array(200,400,600,1000),
            'sizes' => aic_gridListingImageSizes(array(
                  'xsmall' => '2',
                  'small' => '2',
                  'medium' => '3',
                  'large' => '3',
                  'xlarge' => '4',
            )),
        ))
    @endcomponent
@endforeach
