@component('components.organisms._o-row-listing')
    @slot('variation', 'o-blocks__block')
    @foreach ($block['items'] as $item)
        @component('components.molecules._m-listing----'.$block["subtype"].'-row')
            @slot('variation', 'm-listing--inline'.(($block["subtype"] === 'product') ? ' m-listing--inline-feature' : ''))
            @slot('item', $item)
            @if ($block["subtype"] === 'media' or $block["subtype"] === 'event')
                @slot('titleFont','f-list-2')
            @endif
            @if ($block["subtype"] === 'product')
                @slot('titleFont','f-list-3')
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '3:4',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '28',
                          'small' => '12',
                          'medium' => '9',
                          'large' => '9',
                          'xlarge' => '9',
                    )),
                ))
            @else
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '13',
                          'medium' => '13',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
            @endif
        @endcomponent
    @endforeach
@endcomponent
