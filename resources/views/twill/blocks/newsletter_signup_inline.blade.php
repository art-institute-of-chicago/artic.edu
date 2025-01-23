@twillBlockTitle('Newsletter signup inline')
@twillBlockIcon('text')

<x-twill::input
    name='copy'
    label='Custom copy'
    note='Override default copy'
    :maxlength='60'
/>

<x-twill::select
    name='list'
    label='Newsletter target list'
    :options="\App\Models\ExactTargetList::getList()->toArray()"
/>
