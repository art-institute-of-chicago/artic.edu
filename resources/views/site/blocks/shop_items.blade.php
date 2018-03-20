@php
    $ids   = $block->browserIds('shopItems');
    $items = \App\Models\Api\ShopItem::query()->ids($ids)->get();
@endphp

@component('components.atoms._hr')
@endcomponent
@component('components.blocks._text')
    @slot('font', 'f-module-title-1')
    @slot('tag', 'h4')
    {{ 'Featured '.str_plural('Product', $items->count()) }}
@endcomponent

@component('components.organisms._o-row-listing')
    @slot('variation', 'o-blocks__block')
    @foreach ($items as $item)
        @component('components.molecules._m-listing----product-row')
            @slot('variation', 'm-listing--inline m-listing--inline-feature')
            @slot('item', $item)
            @slot('titleFont','f-list-3')
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '3:4',
                'srcset' => array(200,400,600),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '28',
                      'small' => '12',
                      'medium' => '9',
                      'large' => '9',
                      'xlarge' => '9',
                )),
            ))
        @endcomponent
    @endforeach
@endcomponent
