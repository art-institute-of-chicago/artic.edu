@php
    $page = $block->blockable;
    $image = $block->imageAsArray('membership_banner_image', 'desktop');
@endphp
@component('components.molecules._m-cta-banner')
    @slot('image', $image)
    @slot('headline', $block->present()->input('headline'))
    @slot('short_copy', $block->present()->input('short_copy'))
    @slot('href', $block->input('url_address'))
    @slot('button_text', $block->present()->input('link_text'))
@endcomponent
