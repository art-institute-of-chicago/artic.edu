@if (isset($items) && !empty($items))
    @foreach ($items as $item)
        @php
            $currentImageSettings = $imageSettings ?? array(
                'srcset' => array(200,400,600,1000,1500,3000),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                    'xsmall' => '58',
                    'small' => '28',
                    'medium' => '28',
                    'large' => '28',
                    'xlarge' => '21',
                )),
            );

            $currentImageSettings['srcset'] = ImageHelpers::aic_getSrcsetForImage($item['media'], $item['isPublicDomain'] ?? false);

        @endphp

        @component('components.atoms._layered-viewer-img')
            @slot('item', $item)
            @slot('imageSettings', $currentImageSettings ?? '')
        @endcomponent
    @endforeach
@endif
