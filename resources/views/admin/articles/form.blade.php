@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'related', 'label' => 'Further Reading'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Article layout',
        'options' => $articleLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'subtype',
        'label' => 'Article Label'
    ])

    @formField('wysiwyg', [
        'name' => 'heading',
        'label' => 'Header',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'author',
        'label' => 'Author',
        'maxlength' => 255
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Author thumbnail',
        'name' => 'author',
        'note' => 'Minimum image width 600px'
    ])

    @formField('checkbox', [
        'name' => 'is_boosted',
        'label' => 'Boost this article on search results'
    ])

    @formField('wysiwyg', [
        'name' => 'citations',
        'label' => 'Citation',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'quote',
            'list', 'artwork', 'artworks', 'hr', 'citation', 'split_block',
            'membership_banner',
        ]
    ])

@stop

@section('fieldsets')
    <a17-fieldset id="related" title="Further Reading">

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 4,
            'label' => 'Related articles',
        ])

    </a17-fieldset>

    <a17-fieldset id="side_related" title="Sidebar Related - Only one will show up randomly">
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
            'name' => 'sidebarArticle',
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

@endsection
