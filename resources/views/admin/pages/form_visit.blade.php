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
        @formField('input', [
            'name' => 'visit_hour_intro',
            'label' => 'Intro text',
            'type' => 'textarea',
            'translated' => true
        ])

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
        @formField('wysiwyg', [
            'name' => 'visit_hour_subheader',
            'field_name' => 'visit_hour_subheader',
            'label' => 'Description',
            'required' => true,
            'translated' => true,
        ])
        @formField('repeater', ['type' => 'featured_hours'])
    </a17-fieldset>

    <a17-fieldset title="What to Expect" id="expect">
        @formField('repeater', ['type' => 'whatToExpects'])
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

    <a17-fieldset title="Accessibility" id="accessibility">
        @formField('medias', [
            'name' => 'visit_accessibility',
            'label' => 'Image',
        ])

        @formField('input', [
            'name' => 'visit_accessibility_text',
            'label' => 'Accessibility text',
            'type' => 'textarea',
            'translated' => true
        ])

        @formField('input', [
            'name' => 'visit_accessibility_link_text',
            'label' => 'Link text',
            'translated' => true
        ])

        @formField('input', [
            'name' => 'visit_accessibility_link_url',
            'label' => 'Link URL',
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

        @formField('input', [
            'name' => 'visit_parking_accessibility_link',
            'field_name' => 'visit_parking_accessibility_link',
            'label' => 'Visitors with Mobility Needs',
        ])

        @formField('repeater', ['type' => 'locations', 'max' => 2])
    </a17-fieldset>

    <a17-fieldset title="Ways to Explore" id="explore">
        @formField('repeater', ['type' => 'families'])
    </a17-fieldset>

@stop
