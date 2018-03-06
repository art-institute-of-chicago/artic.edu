@php
    $ids = $block->browserIds('artworks');
    $artworks = \App\Models\Api\Artwork::query()->ids($ids)->get();
@endphp
