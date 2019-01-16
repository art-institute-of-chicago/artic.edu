@php

$ids = $block->browserIds('digitalLabels');
$digitalLabel = \App\Models\Api\DigitalLabel::query()->ids($ids)->get()->first();

@endphp

@if (isset($digitalLabel))
    @component('components.molecules._m-listing----label')
        @slot('variation', 'o-blocks__block')
        @slot('item', $digitalLabel)
        @slot('titleFont', 'f-list-4')
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '16:9',
            'srcset' => array(200,400,600,1000),
            'sizes' => aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '58',
                    'medium' => '38',
                    'large' => '28',
                    'xlarge' => '28',
            )),
        ))
    @endcomponent
@endif
