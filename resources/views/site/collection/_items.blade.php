@foreach ($artworks as $item)
    @component('components.molecules._m-listing----artwork')
        @slot('variation', 'o-pinboard__item')
        @slot('item', $item)
        @slot('titleFont', 'f-list-7')
        @slot('subtitleFont', 'f-tertiary')
        @slot('imageSettings', array(
            'fit' => null,
            'ratio' => null,
            'srcset' => array(200,400,600,800),
            'sizes' => aic_gridListingImageSizes(array(
                  'xsmall' => '2',
                  'small' => '2',
                  'medium' => '3',
                  'large' => '4',
                  'xlarge' => '4',
            )),
        ))
        @slot('gtmAttributes', 'data-gtm-event="' . $item->title . '" data-gtm-event-category="collection-nav"')
    @endcomponent
@endforeach
