@formField('input', [
    'name' => 'exhibition_intro',
    'label' => 'Intro text',
])

@formField('browser', [
    'routePrefix' => 'whatson',
    'max' => 2,
    'moduleName' => 'exhibitions',
    'name' => 'exhibitionsExhibitions',
    'label' => 'Featured Exhibitions'
])

@formField('browser', [
    'routePrefix' => 'whatson',
    'max' => 20,
    'moduleName' => 'exhibitions',
    'name' => 'exhibitionsCurrent',
    'label' => 'Listing Exhibitions'
])
