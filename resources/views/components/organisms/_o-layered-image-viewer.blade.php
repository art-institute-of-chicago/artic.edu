<div class="o-gallery o-gallery--mosaic{{ (isset($variation)) ? ' '.$variation : '' }}{{ empty($title) ? ' o-gallery----headerless' : '' }}">
    <div class="o-gallery__media o-gallery__media--2-col@small o-gallery__media--2-col@medium o-gallery__media--2-col@large o-gallery__media--2-col@xlarge" data-behavior="pinboard">
        @component('site.shared._mediaitems')
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
