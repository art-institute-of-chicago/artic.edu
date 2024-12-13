@component('components.organisms._o-gridboard')
    @slot('id', 'publicationList')
    @slot('cols_xsmall','2')
    @slot('cols_small','2')
    @slot('cols_medium','3')
    @slot('cols_large','4')
    @slot('cols_xlarge','4')
    @slot('optionLayout','o-pinboard--2-col@xsmall o-pinboard--2-col@small o-pinboard--2-col@medium o-pinboard--3-col@large o-pinboard--3-col@xlarge')
    @component('site.publications._items')
        @slot('publications', $publications)
    @endcomponent
@endcomponent
