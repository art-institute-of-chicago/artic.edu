@php
    $options = [
        [
            'value' => '{{ \App\Models\Lightbox::VARIATION_DEFAULT }}',
            'label' => 'Default (button)'
        ],
        [
            'value' => '{{ \App\Models\Lightbox::VARIATION_NEWSLETTER }}',
            'label' => 'Newsletter (button + email input)'
        ],
        [
            'value' => '{{ \App\Models\Lightbox::VARIATION_EMAIL }}',
            'label' => 'Email capture (button + email input)'
        ]
    ];

    if (config('aic.show_button_and_date_select_lightbox_variation')) {
        $options[] = [
            'value' => '{{ \App\Models\Lightbox::VARIATION_TICKETING }}',
            'label' => 'Ticketing (button + date select) (WIP)'
        ];
    }
@endphp

@extends('twill::layouts.form')

@section('contentFields')

<x-twill::select
    name='header_variation'
    label='Header Style'
    placeholder='Select style of page header'
    default='default'
    :options="[
        [
            'value' => 'default',
            'label' => 'Default'
        ],
        [
            'value' => 'small',
            'label' => 'Small Image'
        ],
        [
            'value' => 'cta',
            'label' => 'Call to action'
        ],
        [
            'value' => 'feature',
            'label' => 'Featured Content',
        ],
        [
            'value' => 'my_museum_tour',
            'label' => 'My Museum Tour'
        ]
    ]"
/>

<hr/>

<x-twill::formConnectedFields
    field-name='header_variation'
    :field-values="['default', 'small', 'cta']"
    :render-for-blocks='false'
    :keep-alive='true'
>

    <x-twill::medias
        name='hero'
        label='Hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::files
        name='video'
        label='Hero video'
        note='Add an MP4 file'
    />

    <x-twill::medias
        name='mobile_hero'
        label='Hero image, mobile'
        note='Minimum image width 2000px'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='header_variation'
    field-values="cta"
    :render-for-blocks='false'
    :keep-alive='true'
>

    <x-twill::input
        name='header_cta_title'
        label='CTA Title'
    />

    <x-twill::input
        name='header_cta_button_label'
        label='Button Label'
    />

    <x-twill::input
        name='header_cta_button_link'
        label='Button Link'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='header_variation'
    field-values="feature"
    :render-for-blocks='false'
    :keep-alive='true'
>

    <x-twill::formFieldset title="Home Features" id="home-features">

        <x-twill::browser
            name='mainHomeFeatures'
            label='Main feature'
            note='Queue up to 3 home features for the large hero area'
            route-prefix='homepage'
            module-name='homeFeatures'
            :max='3'
        />

    </x-twill::formFieldset>

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='header_variation'
    field-values="my_museum_tour"
    :render-for-blocks='false'
    :keep-alive='true'
>
    <x-twill::wysiwyg
        name='labels.header_my_museum_tour_text'
        label='Intro Text'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='labels.header_my_museum_tour_primary_button_label'
                label='Primary Button Label'
            />
        </x-slot:left>

        <x-slot:right>
            <x-twill::input
                name='labels.header_my_museum_tour_primary_button_link'
                label='Primary Button Link'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='labels.header_my_museum_tour_secondary_button_label'
                label='Secondary Button Label'
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::input
                name='labels.header_my_museum_tour_secondary_button_link'
                label='Secondary Button Link'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::medias
        name='header_my_museum_tour_header_image'
        label='Hero Image'
    />

    <x-twill::medias
        name='header_my_museum_tour_header_image_mobile'
        label='Mobile hero Image'
    />

    <x-twill::medias
        name='header_my_museum_tour_header_image_pdf'
        label='PDF hero Image'
    />

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='labels.header_my_museum_tour_icon_choose_title'
                label='`Choose` Title'
            />
        </x-slot:left>

        <x-slot:right>
            <x-twill::input
                name='labels.header_my_museum_tour_icon_choose_desc'
                label='`Choose` Description'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='labels.header_my_museum_tour_icon_personalize_title'
                label='`Personalize` Title'
            />
        </x-slot:left>

        <x-slot:right>
            <x-twill::input
                name='labels.header_my_museum_tour_icon_personalize_desc'
                label='`Personalize` Description'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='labels.header_my_museum_tour_icon_finish_title'
                label='`Finish` Title'
            />
        </x-slot:left>

        <x-slot:right>
            <x-twill::input
                name='labels.header_my_museum_tour_icon_finish_desc'
                label='`Finish` Description'
            />
        </x-slot:right>
    </x-twill::formColumns>

</x-twill::formConnectedFields>

<x-twill::wysiwyg
    name='listing_description'
    label='Listing description'
    note='Max 255 characters'
    :maxlength="255"
    :toolbar-options="[ 'italic' ]"
/>

@stop

@section('fieldsets')

    <x-twill::formFieldset title="Custom Content" id="custom_content">

        @php
            $blocks = BlockHelpers::getBlocksForEditor([
                '360_embed',
                '360_modal',
                '3d_embed',
                '3d_model',
                '3d_tour',
                'artwork',
                'audio_player',
                'button',
                'citation',
                'custom_banner',
                'digital_label',
                'feature_2x',
                'feature_4x',
                'featured_pages_grid',
                'gallery_new',
                'grid',
                'hr',
                'image',
                'image_slider',
                'list',
                'media_embed',
                'mirador_embed',
                'mirador_modal',
                'mobile_app',
                'my_museum_tour_grid',
                'paragraph',
                'quote',
                'showcase',
                'split_block',
                'tour_stop',
                'video',
            ]);
        @endphp

        <x-twill::block-editor
            :blocks='$blocks'
        />

    </x-twill::formFieldset>

    <x-twill::formFieldset title="Call to Action (Create Tour)" id="create-call-to-action">

        <x-twill::medias
            name='tours_create_cta_module_image'
            label='Image'
        />

        <x-twill::input
            name='labels.tours_create_cta_module_header'
            label='Header'
        />

        <x-twill::wysiwyg
            name='labels.tours_create_cta_module_body'
            label='Body'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::input
            name='labels.tours_create_cta_module_button_text'
            label='Button text'
        />

        <x-twill::radios
            name='variation'
            label='Variation'
            default='\App\Models\Lightbox::VARIATION_DEFAULT'
            :inline='false'
            :options='$options'
        />

        <p>If you choose any variation except "Newsletter", you must fill out the "Metadata" fields below. The "Newsletter" variation works like the newsletter signup in our footer.</p>

        <hr>

        <x-twill::input
            name='labels.tours_create_cta_module_action_url'
            label='Action URL'
            note='e.g. https://join.artic.edu/secure/holiday-annual-fund'
        />

        <x-twill::input
            name='labels.tours_create_cta_module_form_tlc_source'
            label='Form TLC Source'
            note='e.g. AIC17137L01'
        />

        <x-twill::input
            name='labels.tours_create_cta_module_form_token'
            label='Form Token'
            note='e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag'
        />

        <x-twill::input
            name='labels.tours_create_cta_module_form_id'
            label='Form ID'
            note='e.g. webform_client_form_5111'
        />
    </x-twill::formFieldset>
    <x-twill::formFieldset title="Call to Action (Buy Tickets)" id="tickets-call-to-action">

        <x-twill::medias
            name='tours_tickets_cta_module_image'
            label='Image'
        />

        <x-twill::input
            name='labels.tours_tickets_cta_module_header'
            label='Header'
        />

        <x-twill::wysiwyg
            name='labels.tours_tickets_cta_module_body'
            label='Body'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::input
            name='labels.tours_tickets_cta_module_button_text'
            label='Button text'
        />

        <x-twill::radios
            name='variation'
            label='Variation'
            default='\App\Models\Lightbox::VARIATION_DEFAULT'
            :inline='false'
            :options='$options'
        />

        <p>If you choose any variation except "Newsletter", you must fill out the "Metadata" fields below. The "Newsletter" variation works like the newsletter signup in our footer.</p>

        <hr>

        <x-twill::input
            name='labels.tours_tickets_cta_module_action_url'
            label='Action URL'
            note='e.g. https://join.artic.edu/secure/holiday-annual-fund'
        />

        <x-twill::input
            name='labels.tours_tickets_cta_module_form_tlc_source'
            label='Form TLC Source'
            note='e.g. AIC17137L01'
        />

        <x-twill::input
            name='labels.tours_tickets_cta_module_form_token'
            label='Form Token'
            note='e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag'
        />

        <x-twill::input
            name='labels.tours_tickets_cta_module_form_id'
            label='Form ID'
            note='e.g. webform_client_form_5111'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="metadata" title="Overwrite default metadata (optional)">
        <x-twill::input
            name='meta_title'
            label='Metadata Title'
        />

        <x-twill::input
            name='meta_description'
            label='Metadata Description'
            type='textarea'
        />


        <x-twill::input
            name='search_tags'
            label='Internal Search Tags'
            type='textarea'
        />

        <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
    </x-twill::formFieldset>

@stop
