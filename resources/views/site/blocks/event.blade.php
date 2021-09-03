@php
    $eventIds = $block->browserIds('events');
    $event = \App\Models\Event::find($eventIds)->first();
@endphp

@component('components.organisms._o-row-listing')
    @slot('variation', 'o-blocks__block')

    @component('components.molecules._m-listing----event-row')
        @slot('item', $event)
        @slot('variation', 'm-listing--inline')
        @slot('titleFont','f-list-2')
        @slot('showDateWithTime', true)
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '16:9',
            'srcset' => array(200,400,600),
            'sizes' => ImageHelpers::aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '13',
                  'medium' => '13',
                  'large' => '13',
                  'xlarge' => '13',
            )),
        ))
    @endcomponent
@endcomponent
