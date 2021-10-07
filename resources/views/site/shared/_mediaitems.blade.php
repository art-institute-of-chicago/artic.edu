@if (isset($items) && !empty($items))
    @foreach ($items as $item)
        @php
            // Default to `mosaic` sizes, defensively
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

            if ($item['isArtwork'] ?? false) {
                $currentImageSettings['srcset'] = ImageHelpers::aic_getSrcsetForImage($item['media'], $item['isPublicDomain'] ?? false);
            }
        @endphp
        @if ($item['href'] ?? false)
            <a href="{!! $item['href'] !!}" {!! $item['gtmAttributes'] ?? '' !!}>
            @php
                unset($item['gtmAttributes']);
            @endphp
        @endif
        @component('components.molecules._m-media')
            @slot('item', $item)
            @slot('imageSettings', $currentImageSettings ?? '')
        @endcomponent
        @if ($item['href'] ?? false)
            </a>
        @endif
    @endforeach
@endif
