@if( !empty( $items ) )
    @foreach ($items as $date => $item)
        @component('components.molecules._m-date-listing')
            @slot('date', $date)
            @slot('events', $item)
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
            @slot('imageSettingsOnGoing', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '7',
                      'medium' => '7',
                      'large' => '7',
                      'xlarge' => '7',
                )),
            ))
        @endcomponent
    @endforeach
@endif
