@twillBlockTitle('External search bar')
@twillBlockIcon('text')

@formField('input', [
    'name' => 'header',
    'label' => 'Header',
    'note' => 'Not shown if omitted',
])

@formField('input', [
    'name' => 'placeholder',
    'label' => 'Placeholder text',
    'note' => 'Shown inside search bar',
])

@formField('input', [
    'name' => 'url_template',
    'label' => 'Search URL template',
    'note' => 'Use {query} to specify which part should be replaced',
])
