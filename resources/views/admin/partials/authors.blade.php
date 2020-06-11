@formField('input', [
    'name' => 'author_display',
    'label' => 'Author display',
    'maxlength' => 255
])

@formField('browser', [
    'routePrefix' => 'collection',
    'moduleName' => 'authors',
    'name' => 'authors',
    'label' => 'Authors',
    'max' => 10
])
