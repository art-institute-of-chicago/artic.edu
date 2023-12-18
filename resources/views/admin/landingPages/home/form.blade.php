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

<a17-fieldset title="Top Section" id="home-top">

    @formField('wysiwyg', [
        'name' => 'labels.home_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('repeater', ['type' => 'social_links'])

    <hr/>

    @formField('input', [
        'name' => 'labels.home_location_label',
        'label' => 'Location Label'
    ])

    @formField('input', [
        'name' => 'labels.home_location_link',
        'label' => 'Location Link'
    ])

    @formField('input', [
        'name' => 'labels.home_buy_tix_label',
        'label' => 'Tickets Label'
    ])

    @formField('input', [
        'name' => 'labels.home_buy_tix_link',
        'label' => 'Tickets Link'
    ])

</a17-fieldset>

<a17-fieldset title="Custom Content" id="custom_content">

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            '3d_embed',
            '3d_model',
            '3d_tour',
            '360_embed',
            '360_modal',
            'artwork',
            'audio_player',
            'button',
            'citation',
            'collection_block',
            'custom_banner',
            'digital_label',
            'feature_block',
            'featured_pages_grid',
            'gallery_new',
            'grid',
            'hr',
            'image',
            'image_slider',
            'media_embed',
            'membership_banner',
            'mirador_embed',
            'mirador_modal',
            'paragraph',
            'quote',
            'showcase',
            'split_block',
            'stories_block',
            'tour_stop',
            'video',
            'vtour_embed'
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
