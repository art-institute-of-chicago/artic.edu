@php
    $items = [];
    foreach ($block->childs as $item) {
        $item->time = $item->present()->input('time');
        $item->title = $item->present()->input('title');
        $item->blurb = $item->present()->input('description');
        $item->image = $item->imageAsArray('image', 'desktop');
        $items[] = $item;
    }
@endphp


@component('components.organisms._o-row-listing')
    @slot('variation', 'o-blocks__block')
    @foreach ($items as $item)
        @component('components.molecules._m-listing----timeline')
            @slot('item', $item)
            @slot('imageSettings', array(
                'srcset' => array(300,600,800,1200,1600),
                'sizes' => ImageHelpers::aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '58',
                      'medium' => '38',
                      'large' => '28',
                      'xlarge' => '28',
                )),
            ))
        @endcomponent
    @endforeach
@endcomponent
