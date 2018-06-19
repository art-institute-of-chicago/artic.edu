@foreach ($artworks as $item)
    @component('components.molecules._m-listing----'.$item->type)
        @slot('variation', 'o-pinboard__item')
        @slot('item', $item)
        @slot('titleFont',($item->type == 'artwork') ? 'f-list-7' : null)
        @slot('subtitleFont',($item->type == 'artwork') ? 'f-tertiary' : null)
        @slot('imageSettings', array(
            'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
            'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
            'srcset' => array(200,400,600,1000),
            'sizes' => aic_gridListingImageSizes(array(
                  'xsmall' => '2',
                  'small' => '2',
                  'medium' => '3',
                  'large' => '4',
                  'xlarge' => '4',
            )),
        ))
        @slot('gtmAttributes', $gtmAttributes ?? null)
    @endcomponent
@endforeach
