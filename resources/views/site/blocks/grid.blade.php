@php
    $gridTitle = $block->input('heading');
    $gridDescription = $block->input('description');
    $gridLinkLabel = $block->input('grid_link_label');
    $gridLinkHref = $block->input('grid_link_href');
    $variation = $block->input('variation');
    switch ($variation) {
        case '4-wide':
            $width = $widthSmall = '4';
            break;
        case '2-wide':
            $width = $widthSmall = '2';
            break;
        case '3-wide':
        default:
            $width = '3';
            $widthSmall = '2';
            break;
    }
@endphp

<div class="o-grid-block">
    @component('components.molecules._m-title-bar')
        @slot('links', !empty($gridLinkLabel) && !empty($gridLinkHref) ? [
            [
                'label' => $gridLinkLabel,
                'href'  => $gridLinkHref,
                'id' => Str::slug(strip_tags($gridTitle)),
            ]
        ] : null)
        @if (!empty($gridTitle))
            {!!'<span class="o-grid-block__title">'. $gridTitle .'</span>'!!}
        @endif
        @if (!empty($gridDescription))
            {!!'<span class="o-grid-block__description">'. $gridDescription .'</span>'!!}
        @endif
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
        @slot('cols_small', $widthSmall)
        @slot('cols_medium', $width)
        @slot('cols_large', $width)
        @slot('cols_xlarge', $width)
        @foreach ($block->children as $item)
            @component('components.molecules._m-listing----grid-item')
                @slot('url', $item->input('url'))
                @slot('image', $item->imageAsArray('image', 'desktop'))
                @slot('label', $item->input('label'))
                @slot('labelPosition', $item->input('label_position'))
                @slot('title', $item->input('title'))
                @slot('tag', $item->input('tag'))
                @slot('description', $item->input('description'))
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                          'xsmall' => '216px',
                          'small' => '216px',
                          'medium' => '18',
                          'large' => '13',
                          'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent
</div>
