@if (isset($items) && !empty($items))
    @foreach ($items as $item)
        @php
            $currentImageSettings = $imageSettings;
            if (($item['isArtwork'] ?? false) && !($item['isPublicDomain'] ?? false))
            {
                $currentImageSettings['srcset'] = array_values(
                    array_filter($currentImageSettings['srcset'], function($size) {
                        return $size < 843;
                    })
                );
            }
        @endphp
        @component('components.molecules._m-media')
            @slot('item', $item)
            @slot('imageSettings', $currentImageSettings ?? '')
        @endcomponent
    @endforeach
@endif
