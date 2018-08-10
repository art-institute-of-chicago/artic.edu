@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('multi_select', [
        'name' => 'siteTags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('input', [
        'name' => 'short_copy',
        'label' => 'Short intro copy',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero image',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('input', [
        'name' => 'hero_caption',
        'label' => 'Hero image Caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 150
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'gallery', 'video', 'media_embed',  'artwork', 'artworks', 'hr'
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="side_related" title="Sidebar Related—only one will show up randomly">
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'videos',
            'max' => 1,
            'name' => 'videos',
            'label' => 'Related video'
        ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'max' => 1,
            'name' => 'articles',
            'label' => 'Related article',
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 1,
            'name' => 'sidebarExhibitions',
            'label' => 'Related Exhibition',
            'moduleName' => 'exhibitions',
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'sidebarEvent',
            'label' => 'Related event',
            'max' => 1
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
    </a17-fieldset>

@stop
