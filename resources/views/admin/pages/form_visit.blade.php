@section('contentFields')
    @formField('medias', [
        'name' => 'visit_hero',
        'label' => 'Hero image',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('files', [
        'name' => 'video',
        'label' => 'Hero video',
        'note' => 'Add an MP4 file'
    ])

    @formField('medias', [
        'name' => 'visit_mobile',
        'label' => 'Hero image, mobile',
        'note' => 'Minimum image width 2000px'
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Hours" id="hours">
        @formField('medias', [
            'name' => 'visit_featured_hour',
            'label' => 'Image',
            'max' => '1',
            'note' => 'Minimum image width 2000px'
        ])
        @formField('input', [
            'name' => 'visit_hour_header',
            'field_name' => 'visit_hour_header',
            'label' => 'Header',
            'required' => true,
            'translated' => true,
        ])
        @formField('input', [
            'type' => 'text',
            'rows' => 3,
            'name' => 'visit_hour_subheader',
            'field_name' => 'visit_hour_subheader',
            'label' => 'Description',
            'required' => true,
            'translated' => true,
        ])
        @formField('repeater', ['type' => 'featured_hours'])
    </a17-fieldset>

    <a17-fieldset title="Admissions" id="admissions">
        @formField('wysiwyg', [
            'name' => 'visit_admission_description',
            'field_name' => 'visit_admission_description',
            'label' => 'Admission table description',
            'translated' => true,
        ])
        @formField('input', [
            'name' => 'visit_buy_tickets_label',
            'field_name' => 'visit_buy_tickets_label',
            'label' => 'Buy tickets label',
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_buy_tickets_link',
            'field_name' => 'visit_buy_tickets_link',
            'label' => 'Buy tickets link'
        ])
        @formField('input', [
            'name' => 'visit_become_member_label',
            'field_name' => 'visit_become_member_label',
            'label' => 'Become a member label',
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_become_member_link',
            'field_name' => 'visit_become_member_link',
            'label' => 'Become a member link'
        ])
    </a17-fieldset>

    <a17-fieldset title="Featured Offer" id="featured_offer">
        @formField('medias', [
            'name' => 'visit_city_pass',
            'label' => 'Image',
            'note' => 'Minimum image width 2000px'
        ])
        @formField('input', [
            'name' => 'visit_city_pass_title',
            'field_name' => 'visit_city_pass_title',
            'label' => 'Title',
            'required' => true,
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_city_pass_text',
            'field_name' => 'visit_city_pass_text',
            'label' => 'Text',
            'rows' => 3,
            'type' => 'textarea',
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_city_pass_button_label',
            'field_name' => 'visit_city_pass_button_label',
            'label' => 'Button label',
            'required' => true,
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_city_pass_link',
            'field_name' => 'visit_city_pass_link',
            'label' => 'Button link',
            'required' => true,
            'translated' => true
        ])
    </a17-fieldset>

    <a17-fieldset title="Directions" id="directions">

        @formField('medias', [
            'name' => 'visit_map',
            'label' => 'Museum map',
        ])

        @formField('input', [
            'name' => 'visit_transportation_link',
            'field_name' => 'visit_transportation_link',
            'label' => 'Public transportation link',
            'required' => true
        ])

        @formField('input', [
            'name' => 'visit_parking_link',
            'field_name' => 'visit_parking_link',
            'label' => 'Directions & Parking',
            'required' => true
        ])


        @formField('repeater', ['type' => 'locations', 'max' => 2])
    </a17-fieldset>

    <a17-fieldset title="Dining" id="dining_hours">
        @formField('input', [
            'name' => 'visit_dining_link',
            'label' => 'Explore all dining link'
        ])

        @formField('repeater', ['type' => 'dining_hours'])
    </a17-fieldset>

    <a17-fieldset title="FAQs" id="faq">
        @formField('input', [
            'name' => 'visit_faq_accessibility_link',
            'label' => 'Accessibility information link'
        ])
        @formField('input', [
            'name' => 'visit_faq_more_link',
            'label' => "More FAQs and guidelines link"
        ])

        @formField('repeater', ['type' => 'faqs'])
    </a17-fieldset>

    <a17-fieldset title="Tour Pages" id="tourpages">
        @formField('browser', [
        'routePrefix' => 'generic',
            'max' => 3,
            'moduleName' => 'genericPages',
            'name' => 'visitTourPages',
            'label' => 'Tour pages'
        ])
    </a17-fieldset>

    <a17-fieldset title="Families, teens and educators" id="families">
        @formField('repeater', ['type' => 'families'])
    </a17-fieldset>
@stop
