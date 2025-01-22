@section('contentFields')
    <x-twill::medias
        name='visit_hero'
        label='Hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::files
        name='video'
        label='Hero video'
        note='Add an MP4 file'
    />

    <x-twill::medias
        name='visit_mobile'
        label='Hero image, mobile'
        note='Minimum image width 2000px'
    />
@stop

@section('fieldsets')
    <a17-fieldset title="Hours" id="hours">
        <x-twill::checkbox
            name='visit_hide_hours'
            label='Hide hours table and image'
        />

        <x-twill::input
            name='visit_hour_intro'
            label='Intro text'
            type='textarea'
        />

        <x-twill::medias
            name='visit_featured_hour'
            label='Image'
            note='Minimum image width 2000px'
            :max='1'
        />
        <x-twill::wysiwyg
            name='visit_hour_image_caption'
            label='Image caption'
            :toolbar-options="[ 'italic', 'link' ]"
        />

        <x-twill::input
            name='visit_hour_header'
            label='Header'
            :required='true'
        />

        <x-twill::wysiwyg
            name='visit_hour_subheader'
            label='Description'
            :required='true'
        />
        <x-twill::repeater
            type="featured_hours"
        />
    </a17-fieldset>

    <a17-fieldset title="Call to Action" id="call-to-action">
        <x-twill::input
            name='visit_cta_module_header'
            label='Header'
        />

        <x-twill::wysiwyg
            name='visit_cta_module_body'
            label='Body'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::input
            name='visit_cta_module_button_text'
            label='Button text'
        />

        <x-twill::input
            name='visit_cta_module_action_url'
            label='Button URL'
            note='e.g. https://sales.artic.edu/admissions'
        />
    </a17-fieldset>

    <a17-fieldset title="What to Expect" id="expect">
        <x-twill::input
            name='visit_what_to_expect_more_text'
            label='More link text'
        />
        <x-twill::input
            name='visit_what_to_expect_more_link'
            label='More link'
        />
        <x-twill::repeater
            type="what_to_expects"
        />
    </a17-fieldset>

    <a17-fieldset title="Admissions" id="admissions">
        <x-twill::wysiwyg
            name='visit_admission_description'
            label='Admission table description'
        />
        <x-twill::input
            name='visit_buy_tickets_label'
            label='Buy tickets label'
        />
        <x-twill::input
            name='visit_buy_tickets_link'
            label='Buy tickets link'
        />
        <x-twill::input
            name='visit_become_member_label'
            label='Become a member label'
        />
        <x-twill::input
            name='visit_become_member_link'
            label='Become a member link'
        />
    </a17-fieldset>

    <a17-fieldset title="FAQs" id="faq">
        <x-twill::input
            name='visit_faq_accessibility_link'
            label='Accessibility information link'
        />
        <x-twill::input
            name='visit_faq_more_link'
            label="More FAQs and guidelines link"
        />

        <x-twill::repeater
            type="faqs"
        />
    </a17-fieldset>

    <a17-fieldset title="CityPASS" id="citypass">
        <x-twill::medias
            name='visit_city_pass'
            label='Image'
            note='Minimum image width 2000px'
        />
        <x-twill::input
            name='visit_city_pass_title'
            label='Title'
            :required='true'
        />
        <x-twill::input
            name='visit_city_pass_text'
            label='Text'
            :rows='3'
            type='textarea'
        />
        <x-twill::input
            name='visit_city_pass_button_label'
            label='Button label'
            :required='true'
        />
        <x-twill::input
            name='visit_city_pass_link'
            label='Button link'
            :required='true'
        />
    </a17-fieldset>

    <a17-fieldset title="Accessibility" id="accessibility">
        <x-twill::medias
            name='visit_accessibility'
            label='Image'
        />

        <x-twill::input
            name='visit_accessibility_text'
            label='Accessibility text'
            type='textarea'
        />

        <x-twill::input
            name='visit_accessibility_link_text'
            label='Link text'
        />

        <x-twill::input
            name='visit_accessibility_link_url'
            label='Link URL'
            note='Accepts HTML tags'
        />
    </a17-fieldset>

    <a17-fieldset title="Directions" id="directions">

        <x-twill::medias
            name='visit_map'
            label='Museum map'
        />

        <x-twill::input
            name='visit_transportation_link'
            label='Public transportation link'
            :required='true'
        />

        <x-twill::input
            name='visit_parking_link'
            label='Directions & Parking'
            :required='true'
        />

        <x-twill::input
            name='visit_parking_accessibility_link'
            label='Visitors with Mobility Needs'
        />

        <x-twill::repeater
            type='locations'
            :max='2'
        />
    </a17-fieldset>

    <a17-fieldset title="Enhance Your Visit" id="explore">
        <x-twill::repeater
            type="families"
        />
    </a17-fieldset>

@stop
