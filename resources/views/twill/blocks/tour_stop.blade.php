@twillBlockTitle('Audio Tour Stop')
@twillBlockIcon('image')

<x-twill::browser
    name='tour_stop'
    label='Audio Tour Stop'
    route-prefix='general'
    module-name='tourStops'
    :max='1'
/>

<x-twill::input
    name='title_display'
    label='Title override (optional)'
    note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
/>

<x-twill::checkbox
    name='hidePromoText'
    label='Hide promo text'
/>
