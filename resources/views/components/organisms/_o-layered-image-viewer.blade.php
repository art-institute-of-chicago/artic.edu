<div>
    <div>
        @component('components.molecules._m-liv-img')
            @slot('items', $items)
            @slot('imageSettings', $imageSettings ?? array(
                'srcset' => array(200,400,600,1000,1500,3000),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '28',
                    'medium' => '28',
                    'large' => '28',
                    'xlarge' => '21',
                )),
            ))
        @endcomponent
    </div>
</div>
