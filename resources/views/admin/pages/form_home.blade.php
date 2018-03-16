@section('contentFields')
    @formField('input', [
        'name' => 'home_intro',
        'label' => 'Intro text',
    ])

    @formField('browser', [
    'routePrefix' => 'homepage',
        'max' => 10,
        'moduleName' => 'homeFeatures',
        'name' => 'homeFeatures',
        'label' => 'Home Features'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 2,
        'moduleName' => 'exhibitions',
        'name' => 'homeExhibitions',
        'label' => 'Related Exhibitions'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 4,
        'moduleName' => 'events',
        'name' => 'homeEvents',
        'label' => 'Related Events',
        'note' => 'Select up to 4 events you want to feature on the homepage'
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 5,
        'moduleName' => 'shopItems',
        'name' => 'homeShopItems',
        'label' => 'Related Shop items',
        'note' => 'Select up to 5 shop items you want to feature on the homepage'
    ])

@stop

@section('fieldsets')
    <a17-fieldset title="Membership Module" id="membership">

        @formField('medias', [
            'label' => 'Image',
            'name' => 'home_membership_module_image'
        ])

        @formField('input', [
            'name' => 'home_membership_module_headline',
            'label' => 'Headline',
        ])

        @formField('input', [
            'name' => 'home_membership_module_short_copy',
            'label' => 'Short Copy',
        ])

        @formField('input', [
            'name' => 'home_membership_module_button_text',
            'label' => 'Button Text',
        ])

        @formField('input', [
            'name' => 'home_membership_module_url',
            'label' => 'URL',
        ])

    </a17-fieldset>
@stop
