@twillBlockTitle('Audio Tour Stop')
@twillBlockIcon('image')

@formField('browser', [
    'routePrefix' => 'general',
    'name' => 'tour_stop',
    'moduleName' => 'tourStops',
    'label' => 'Audio Tour Stop',
    'max' => 1
])

<x-twill::input
    name='title_display'
    label='Title override (optional)'
    note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
/>

<x-twill::checkbox
    name='hidePromoText'
    label='Hide promo text'
/>
