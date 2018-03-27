@php
    $page = $block->blockable;
    $image = $block->imageAsArray('image', 'desktop');
@endphp
@component('components.molecules._m-cta-banner----become-a-member')
    @slot('image', $image)
    @slot('headline', $block->input('headline'))
    @slot('short_copy', $block->input('short_copy'))
    @slot('href', $block->input('url_address'))
    @slot('button_text', $block->input('link_text'))
@endcomponent
