@php
    $ids = $block->browserIds('experiences');
    $items = \App\Models\Experience::find($ids);
@endphp
@if ($items->count() > 0)
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--feature-2x m-media--l')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @php ($count = 0)
        @foreach ($items as $item)
            @php ($count += 1)
            @component('components.molecules._m-listing----experience')
                @slot('titleFont', 'f-list-4')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600,1000,1500),
                    'sizes' => aic_gridListingImageSizes(array(
                          'xsmall' => '1',
                          'small' => '2',
                          'medium' => '2',
                          'large' => '2',
                          'xlarge' => '2',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif
