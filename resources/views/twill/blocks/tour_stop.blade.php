@twillBlockTitle('Audio Tour Stop')
@twillBlockIcon('image')

@formField('browser', [
    'routePrefix' => 'general',
    'name' => 'tour_stop',
    'moduleName' => 'tourStops',
    'label' => 'Audio Tour Stop',
    'max' => 1
])

@formField('input', [
    'name' => 'title_display',
    'label' => 'Title override (optional)',
    'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
])

@formField('checkbox', [
    'name' => 'hidePromoText',
    'label' => 'Hide promo text'
])
