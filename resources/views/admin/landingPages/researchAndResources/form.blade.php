@extends('twill::layouts.form')

@section('contentFields')

@formField('select', [
    'name' => 'header_variation',
    'label' => 'Header Style',
    'placeholder' => 'Select style of page header',
    'default' => 'default',
    'options' => [
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
            'label' => 'Featured Content'
        ],
    ]
])

<hr/>

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => ['default', 'small', 'cta'],
    'renderForBlocks' => false
])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero image',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('files', [
        'name' => 'video',
        'label' => 'Hero video',
        'note' => 'Add an MP4 file'
    ])

    @formField('medias', [
        'name' => 'mobile_hero',
        'label' => 'Hero image, mobile',
        'note' => 'Minimum image width 2000px'
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'cta',
    'renderForBlocks' => false
])

    @formField('input', [
        'name' => 'header_cta_title',
        'label' => 'CTA Title'
    ])

    @formField('input', [
        'name' => 'header_cta_button_label',
        'label' => 'Button Label'
    ])

    @formField('input', [
        'name' => 'header_cta_button_link',
        'label' => 'Button Link'
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'header_variation',
    'fieldValues' => 'feature',
    'renderForBlocks' => false
])

    @formField('browser', [
        'routePrefix' => 'generic',
        'max' => 3,
        'moduleName' => 'pageFeatures',
        'name' => 'primaryFeatures',
        'label' => 'Main feature',
        'note' => 'Queue up to 3 home features for the large hero area',
    ])

@endcomponent

@stop

@section('fieldsets')

<a17-fieldset title="Research Content" id="research_content">

    @formField('input', [
        'name' => 'labels.resources_landing_title',
        'label' => 'Title',
    ])

    @formField('input', [
        'name' => 'labels.resources_landing_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('medias', [
        'label' => 'Hero image',
        'name' => 'research_landing_image'
    ])

    @formField('browser', [
        'routePrefix' => 'generic',
        'max' => 9,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesFeaturePages',
        'label' => 'Featured pages'
    ])

    @formField('browser', [
        'routePrefix' => 'generic',
        'max' => 3,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesStudyRooms',
        'label' => 'Study room pages'
    ])

    @formField('browser', [
        'routePrefix' => 'generic',
        'max' => 1,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesStudyRoomMore',
        'label' => 'Study room more link'
    ])

</a17-fieldset>

<a17-fieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'image', 'hr', 'hr', 'artwork', 'split_block', 'split_block', 'gallery_new', 'video', 'video', 'quote', 'quote', 'tour_stop', 'tour_stop', 'media_embed', 'media_embed', 'list', 'grid', 'grid', 'image_slider', 'button', 'audio_player', '360_embed', 'mirador_embed', '3d_embed', 'membership_banner', 'membership_banner', 'showcase', '3d_tour', '3d_model', 'stories_block', 'citation', 'mobile_app', 'mirador_modal', 'digital_label', '360_modal'
        ])
    ])

</a17-fieldset>

<a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
    @formField('input', [
        'name' => 'meta_title',
        'label' => 'Metadata Title'
    ])

    @formField('input', [
        'name' => 'meta_description',
        'label' => 'Metadata Description',
        'type' => 'textarea'
    ])


    @formField('input', [
        'name' => 'search_tags',
        'label' => 'Internal Search Tags',
        'type' => 'textarea'
    ])

    <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
</a17-fieldset>

@stop
