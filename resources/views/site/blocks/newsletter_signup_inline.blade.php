@component('components.molecules._m-aside-newsletter')
    @slot('variation','m-aside-newsletter--inline o-blocks__block')
    @slot('placeholder','Email Address')
    @slot('list', $block->input('list'))
    @slot('copy', $block->present()->input('copy'))
@endcomponent
