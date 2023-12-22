@component('components.molecules._m-multi-col-list')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('title', 'All tags on this artwork')
    @slot('items', $tags)
@endcomponent