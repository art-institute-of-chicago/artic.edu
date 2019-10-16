@section('contentFields')
    @formField('input', [
        'name' => 'home_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 3,
        'moduleName' => 'homeFeatures',
        'name' => 'mainHomeFeatures',
        'label' => 'Main feature',
        'note' => 'Queue up to 3 home features for the large hero area',
    ])

    @formField('browser', [
        'routePrefix' => 'homepage',
        'max' => 5,
        'moduleName' => 'homeFeatures',
        'name' => 'secondaryHomeFeatures',
        'label' => 'Secondary features',
        'note' => 'Queue up to 5 home features for the two smaller hero areas',
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Plan your visit" id="plan-your-visit">
        @formField('input', [
            'name' => 'home_plan_your_visit_link_1_text',
            'label' => 'First "Plan your visit" link text',
        ])

        @formField('input', [
            'name' => 'home_plan_your_visit_link_1_url',
            'label' => 'First "Plan your visit" link URL',
        ])

        @formField('input', [
            'name' => 'home_plan_your_visit_link_2_text',
            'label' => 'Second "Plan your visit" link text',
        ])

        @formField('input', [
            'name' => 'home_plan_your_visit_link_2_url',
            'label' => 'Second "Plan your visit" link URL',
        ])

        @formField('input', [
            'name' => 'home_plan_your_visit_link_3_text',
            'label' => 'Third "Plan your visit" link text',
        ])

        @formField('input', [
            'name' => 'home_plan_your_visit_link_3_url',
            'label' => 'Third "Plan your visit" link URL',
        ])
</a17-fieldset>

    <a17-fieldset title="Exhibitions and Event" id="exhibitions-and-events">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 2,
            'moduleName' => 'exhibitions',
            'name' => 'homeExhibitions',
            'label' => 'Featured exhibitions'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 10,
            'moduleName' => 'events',
            'name' => 'homeEvents',
            'label' => 'Featured events',
            'note' => 'Select up to 10 events you want to feature on the homepage'
        ])
    </a17-fieldset>

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
            'label' => 'Short copy',
        ])

        @formField('input', [
            'name' => 'home_membership_module_button_text',
            'label' => 'Button text',
        ])

        @formField('input', [
            'name' => 'home_membership_module_url',
            'label' => 'URL',
        ])
    </a17-fieldset>

    <a17-fieldset title="From the Collection" id="from-the-collection">
        @formField('browser', [
            'routePrefix' => 'homepage',
            'max' => 20,
            'moduleName' => 'collectionFeatures',
            'name' => 'collectionFeatures',
            'label' => 'Collection features'
        ])
    </a17-fieldset>

    <a17-fieldset title="From the Shop" id="from-the-shop">
        @formField('browser', [
            'routePrefix' => 'general',
            'max' => 5,
            'moduleName' => 'shopItems',
            'name' => 'homeShopItems',
            'label' => 'Featured shop items',
            'note' => 'Select up to 5 shop items you want to feature on the homepage'
        ])
    </a17-fieldset>
@stop
