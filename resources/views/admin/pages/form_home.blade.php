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
    'hint' => 'TO BE REMOVED: Select which exhibition you want to feature on the homepage',
    'max' => 20
])
