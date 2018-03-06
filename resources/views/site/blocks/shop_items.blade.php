@php
    $ids   = $block->browserIds('shopItems');
    $items = \App\Models\Api\ShopItem::query()->ids($ids)->get();
@endphp
