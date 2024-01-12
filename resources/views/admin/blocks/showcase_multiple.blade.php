@twillBlockTitle('Showcase Multiple')
@twillBlockIcon('image')

@formField('select', [
    'name' => 'styling',
    'label' => 'Styling',
    'required' => true,
    'unpack' => true,
    'default' => 'default',
    'options' => collect([
        'default' => 'Default',
        'experience-with-us' => 'Experience with Us',
        'learn-with-us' => 'Learn with Us',
        'make-with-us' => 'Make with Us',
    ]),
])

@formField('input', [
    'name' => 'header',
    'label' => 'Header',
])

@formField('input', [
    'name' => 'intro',
    'label' => 'Intro',
])

@formField('repeater', ['type' => 'showcase_item'])
