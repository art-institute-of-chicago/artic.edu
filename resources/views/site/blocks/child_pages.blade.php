@php
    $page = $block->blockable;
    $children = $page->children;

    if ($children->count() > 0 && $children->count() % 2 != 0) {
        $listing = $children->first();
        $grid    = $children->slice(1);
    } else {
        $grid = $children->all();
    }

@endphp

@if (isset($listing) && !empty($listing))
    @component('components.organisms._o-row-listing')
        @slot('variation', 'o-blocks__block')
        @component('components.molecules._m-listing----generic')
            @slot('item', $listing)
            @slot('image', $listing->imageFront('listing'))
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600,1000,1500),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '58',
                      'medium' => '38',
                      'large' => '28',
                      'xlarge' => '28',
                )),
            ))
        @endcomponent
    @endcomponent
@endif

@if (isset($grid) && !empty($grid))
    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-blocks__block  o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @foreach ($grid as $item)
            @component('components.molecules._m-listing----generic')
                @slot('item', $item)
                @slot('image', $item->imageFront('listing'))
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '28',
                          'small' => '28',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
@endif
