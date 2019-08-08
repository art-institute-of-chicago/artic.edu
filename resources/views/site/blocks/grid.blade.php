@php
    $gridTitle = $block->input('grid_title');
    $gridLinkLabel = $block->input('grid_link_label');
    $gridLinkHref = $block->input('grid_link_href');
@endphp

@component('components.molecules._m-title-bar')
    @slot('links', !empty($gridLinkLabel) && !empty($gridLinkHref) ? [
        [
            'label' => $gridLinkLabel,
            'href'  => $gridLinkHref,
        ]
    ] : null)
    @if (!empty($gridTitle))
        {{ $gridTitle }}
    @endif
@endcomponent

@component('components.atoms._hr')
@endcomponent
@component('components.organisms._o-grid-listing')
    @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','3')
    @slot('cols_xlarge','3')
    @foreach ($block->childs as $item)
        @component('components.molecules._m-listing----grid-item')
            @slot('url', $item->input('url'))
            @slot('image', $item->imageAsArray('image', 'desktop'))
            @slot('label', $item->input('label'))
            @slot('title', $item->input('title'))
            @slot('tag', $item->input('tag'))
            @slot('description', $item->input('description'))
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
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
