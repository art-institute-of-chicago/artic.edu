@php
    $items = [];
    foreach ($block->childs as $item) {
        $item->subtype = $item->present()->input('tag');
        $item->title = $item->present()->input('header');
        $item->shortDesc = $item->present()->input('description');
        $item->url = $item->input('external_link');
        $items[] = $item;
    }
@endphp

@component('components.organisms._o-row-listing')
    @slot('variation', 'o-blocks__block')
    @foreach ($items as $item)
        @component('components.molecules._m-listing----generic-row')
            @slot('item', $item)
            @slot('image', $item->imageAsArray('image', 'desktop'))
            @slot('variation', 'm-listing--inline')
            @slot('titleFont','f-list-2')
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '13',
                      'medium' => '13',
                      'large' => '13',
                      'xlarge' => '13',
                )),
            ))
        @endcomponent
    @endforeach
@endcomponent
