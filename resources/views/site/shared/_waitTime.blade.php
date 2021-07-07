@component('components.molecules._m-link-list')
    @slot('variation', isset($variation) ? $variation : '')
    @slot('links', $item->present()->navigationWaitTime())
@endcomponent
