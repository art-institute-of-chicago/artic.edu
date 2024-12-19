@component('components.organisms._o-gridboard')
    @slot('id', 'publicationList')
    @slot('cols_xsmall','2')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @component('site.publications._items')
        @slot('publications', $publications)
    @endcomponent
@endcomponent
