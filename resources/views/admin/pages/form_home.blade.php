@formField('input', [
    'name' => 'home_intro',
    'label' => 'Intro text',
])

@formField('browser', [
    'routePrefix' => 'whatson',
    'moduleName' => 'exhibitions',
    'name' => 'homeExhibitions',
    'label' => 'Featured exhibitions',
    'note' => 'Select up to 4 exhibitions you want to feature on the homepage',
    'max' => 4
])

@formField('browser', [
    'routePrefix' => 'whatson',
    'moduleName' => 'events',
    'name' => 'homeEvents',
    'label' => 'Featured events',
    'note' => 'Select up to 3 events you want to feature on the homepage',
    'max' => 3
])
