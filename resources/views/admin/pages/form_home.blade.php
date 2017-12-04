<section class="box">
    <header class="header_small">
        <h3><b>Homepage</b></h3>
    </header>

    @formField('input', [
        'field' => 'home_intro',
        'field_name' => 'Intro text',
    ])
</section>

@formField('browser', [
    'routePrefix' => 'whatson',
    'relationship' => 'homeExhibitions',
    'module_name' => 'exhibitions',
    'relationship_name' => 'featured exhibitions',
    'custom_title_prefix' => 'Add',
    'with_multiple' => true,
    'with_sort' => true,
    'hint' => 'Select up to 4 exhibitions you want to feature on the homepage',
    'max' => 4
])

@formField('browser', [
    'routePrefix' => 'whatson',
    'relationship' => 'homeEvents',
    'module_name' => 'events',
    'relationship_name' => 'featured events',
    'custom_title_prefix' => 'Add',
    'with_multiple' => true,
    'with_sort' => true,
    'hint' => 'Select up to 3 events you want to feature on the homepage',
    'max' => 3
])
