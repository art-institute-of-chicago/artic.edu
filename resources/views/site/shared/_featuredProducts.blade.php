@component('components.molecules._m-title-bar')
    @slot('links', $titleLinks)
    {{ $title }}
@endcomponent

@component('components.atoms._hr')
@endcomponent

@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
    @slot('cols_medium','4')
    @slot('cols_large','5')
    @slot('cols_xlarge','5')
    @slot('behavior','dragScroll')
    @foreach ($products as $item)
        @component('components.molecules._m-listing----product')
            @slot('item', $item)
            @slot('imageSettings', array(
                'fit' => 'fill',
                'fill'=> 'blur',
                'ratio' => '3:4',
                'srcset' => array(200,400,600),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                      'xsmall' => '216px',
                      'small' => '216px',
                      'medium' => '18',
                      'large' => '13',
                      'xlarge' => '13',
                )),
            ))
            @slot('gtmAttributes', 'data-gtm-event="'.StringHelpers::getUtf8Slug($item['title'] ?? 'unknown title').'" data-gtm-event-category="shop-listing'.($loop->index + 1).'"')
        @endcomponent
    @endforeach
@endcomponent
